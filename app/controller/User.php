<?php

namespace app\controller;

use support\Request;
use Tinywan\Jwt\JwtToken;
use GuzzleHttp\Client;

class User extends Base
{
    

    /**
     * @Description
     * 登录
     * @return void
     */
    public function login(Request $request)
    {
        $code = $request->post('code');
        if (empty($code)) {
            return $this->fail('参数错误', 40001);
        }
        $client =  new \GuzzleHttp\Client([
            'timeout' => 2.0
        ]);
        $app_id = 'wx2e19b3bb60615ba3';
        $secret = '409f2ad0d419f32f7ba359cd1cdfbd24';
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid='.$app_id.'&secret='.$secret.'&js_code='.$code.'&grant_type=authorization_code';
        $response = $client->request('GET', $url);
        $data = $response->getBody()->getContents();
        
        return $this->success($data);
    }
}