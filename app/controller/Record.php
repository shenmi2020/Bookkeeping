<?php

namespace app\controller;

use app\model\Account;
use support\Request;
use app\model\Record as RecordModel;
use support\Db;
use app\model\User as UserModel;

class Record extends Base
{

    /**
     * 账单列表
     */
    public function listInfo(Request $request)
    {
        $param =  $request->post();
        if (empty($param['aid'])) {
            return $this->fail('账本不能为空');
        }
        $pageIndex = $param['pageIndex'] ?? 1;
        $pageSize = $param['pageSize'] ?? 20;

        $relation = UserModel::where('id', $request->user['id'])->first()->accounts()->where('aid', $param['aid'])->exists();
        if (!$relation) {
            return $this->fail('没有权限');
        }

        $data = RecordModel::where('aid', $param['aid'])->offset(($pageIndex - 1) * $pageSize)
            ->limit($pageSize)
            ->orderBy('day', 'desc')
            ->orderBy('id', 'desc')
            ->get()->toArray();
        
        return $this->success($data);
    }

    public function add(Request $request)
    {
        $param = $request->post();
    
        if (empty($param['aid'])) {
            return $this->fail('账本不能为空');
        }
        if (empty($param['category_id'])) {
            return $this->fail('分类不能为空');
        }
        if (empty($param['type'])) {
            return $this->fail('类型不能为空');
        }
        if (empty($param['money'])) {
            return $this->fail('金额不能为空');
        }
        if (empty($param['day'])) {
            return $this->fail('日期不能为空');
        }
       
        RecordModel::insert([
            'category_id' => $param['category_id'],
            'day' => $param['day'],
            'aid' => $param['aid'],
            'type' => $param['type'],
            'money' => $param['money'],
            'remark' => isset($param['remark']) && trim($param['remark']) !== '' ? trim($param['remark']) : '',
            'uid' => $request->user['id'],
            'create_time' => time()
        ]);
        
        return $this->success('添加成功');
    }

}