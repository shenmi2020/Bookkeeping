<?php

namespace app\controller;

use support\Request;
use Tinywan\Jwt\JwtToken;

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
        var_dump(json_encode($token));
        // return response('hello webman');
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
