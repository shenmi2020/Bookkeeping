<?php

namespace app\controller;

use support\Request;
use Tinywan\Jwt\JwtToken;
use GuzzleHttp\Client;
use support\Db;
use app\model\User as UserModel;

class User extends Base
{
    /**
     * 
     */
    public function demo1(Request $request)
    {
        $user = [
            'id'  => 20225,
            'name'  => 'Tinywan',
            'email' => 'Tinywan@163.com'
        ];
        $accessToken = JwtToken::generateToken($user);
        // var_dump(json_encode($accessToken));
        // $accessToken = JwtToken::refreshToken();
        Db::table('record')->insert([
            'category_id' => 1,
            'day' => '2020-09-08',
            'remark' => '备注',
            'aid' => 1,
            'money' => 20
        ]);
        return json(['code' => 201, 'data' => $accessToken]);
    }

    public function demo2(Request $request)
    {
        return json(['code' => 0, 'data' => $request->user]);
    }


    /**
     * @Description
     * 登录
     * @return void
     */
    public function login(Request $request)
    {
        $param = $request->post();
        // \var_dump($request->post());
        if (empty($param['code'])) {
            return $this->fail('参数错误', 40001);
        }
        $client =  new Client([
            'timeout' => 2.0
        ]);
        $app_id = 'wx2e19b3bb60615ba3';
        $secret = '409f2ad0d419f32f7ba359cd1cdfbd24';
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$app_id.'&secret='.$secret.'&js_code='.$param['code'].'&grant_type=authorization_code';
        $response = $client->request('GET', $url);
        $data = $response->getBody()->getContents();
        $result = json_decode($data, true);
        if (!isset($result['openid'])) {
            return $this->fail('服务器异常', 50000);
        }
        $user = UserModel::where('open_id', $result['openid'])->first()->toArray();
        if (empty($user)) {
            $uid = UserModel::insertGetId([
                'open_id' => $result['openid'],
                'create_time' => time(),
            ]);
            $person = [
                'id' => $uid,
                'open_id' => $result['openid']
            ];
        } else {
            $person = $user;
        }
        $accessToken = JwtToken::generateToken($person);

        // 如果新用户创建默认账本
        $relation = Db::table('account')->where('uid', $person['id'])->where('status', 0)->first();
        if (empty($relation)) {
            $aid = Db::table('account')->insertGetId([
                'name' => '默认账本',
                'create_time' => time(),
                'uid' => $person['id']
            ]);
            Db::table('user_relation')->insert([
                'user_id' => $person['id'],
                'aid' => $aid,
                'create_time' => time()
            ]);
            $accessToken['aid'] = $aid;
        }
        
        // 判断账本权限
        if (!empty($param['aid'])) {
            $aid_res = Db::table('user_relation')->where('user_id', $person['id'])->where('aid', $param['aid'])->first();
            if (empty($aid_res)) {
                $my_acc = Db::table('user_relation')->where('user_id', $person['id'])->orderBy('aid', 'desc')->first();
                if (!empty($my_acc)) {
                    $accessToken['aid'] = $my_acc['aid'];
                }
                
            }
        }
        return $this->success($accessToken);
    }
}