<?php
namespace app\controller;

// use support\Response;

class Base
{
    /**
     * 成功数据返回
     *
     * @param mixed $data           返回数据
     * @param int   $business_code  业务返回码
     *
     */
    public function success($data = '', $msg = '', int $business_code = 0)
    {
        return json([
            'code' => $business_code,
            'data' => $data,
            'msg' => $msg == '' ? 'success': $msg
        ]);
    }

    /**
     * 失败数据返回
     *
     * @param mixed $data           返回数据
     * @param int   $business_code  业务返回码
     *
     */
    public function fail($msg = '', int $business_code = 40000)
    {
        return json([
            'code' => $business_code,
            'msg' => $msg == '' ? 'fail': $msg
        ]);
    }

}