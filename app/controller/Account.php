<?php

namespace app\controller;

use app\model\Account as AccountModel;
use app\model\User as UserModel;
use support\Request;

class Account extends Base
{

    /**
     * 账本列表
     */
    public function listInfo(Request $request)
    {
        $data = UserModel::where('id', $request->user['id'])->first()->accounts()->orderBy('id', 'desc')->get();
        return $this->success($data); 
    }

}