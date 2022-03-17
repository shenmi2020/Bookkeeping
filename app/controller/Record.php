<?php

namespace app\controller;

use support\Request;
use support\Log;
use app\model\Record as RecordModel;

class Record extends Base
{

    public function listInfo(Request $request)
    {
        $data = RecordModel::first()->toArray();
        
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