<?php

namespace app\controller;

use support\Request;
use Tinywan\Jwt\JwtToken;

class User
{

    /**
     * @Description
     * 登录
     * @return void
     */
    public function login(Request $request)
    {
        return json($request->user);
    }
}