<?php

namespace app\controller;

use support\Request;
use Tinywan\Jwt\JwtToken;
use support\Db;

class Index
{
    public function index(Request $request)
    {
        $user = [
            'id'  => 202211,
            'name'  => 'Tinywan',
            'email' => 'Tinywan@163.com'
        ];
        $token = JwtToken::generateToken($user);
        // var_dump(json_encode($token));
        $user = Db::table('account_user')->first();
        // var_dump($user);
        return response('hello webman'.json_encode($token));
    }

    public function view(Request $request)
    {
        return view('index/view', ['name' => 'webman']);
    }

    public function json(Request $request)
    {
        return json(['code' => 0, 'msg' => 'ok']);
    }

}
