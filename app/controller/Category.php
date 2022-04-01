<?php

namespace app\controller;

use app\model\Category as CategoryModel;
use support\Db;
use support\Request;

class Category extends Base
{

    public function listInfo(Request $request)
    {
        $data = CategoryModel::where('status', '<>', -1)->where(function($query) use  ($request) {
            return $query->where('uid', 0)->orWhere('uid', $request->user['id']);
        })->orderBy('sort', 'desc')->get();
      
        return $this->success($data);
    }



}