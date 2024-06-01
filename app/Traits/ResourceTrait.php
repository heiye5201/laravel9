<?php

namespace App\Traits;

trait ResourceTrait
{

    // service 返回格式化
    protected function format($data = [], $msg = 'ok')
    {
        return ['status' => true, 'data' => $data, 'msg' => $msg];
    }


    protected function formatError($msg = 'error', $data = [])
    {
        return ['status' => false, 'data' => $data, 'msg' => $msg];
    }


    // Controller 返回格式化

    // 成功返回数据
    protected function success($data = [], $msg = "ok")
    {
        return ['code' => 200, 'msg' => $msg, 'data' => $data];
    }

    // 失败返回数据
    protected function error($msg = "fail", $data = [])
    {
        return ['code' => 500, 'msg' => $msg, 'data' => $data];
    }

    // 自定义返回数据
    protected function auto($code, $msg = "Other", $data = [])
    {
        return ['code' => $code, 'msg' => $msg, 'data' => $data];
    }

    // 快捷返回数据处理
    protected function handle($data)
    {
        return $data['status'] ? $this->success($data['data']) : $this->error($data['msg'], $data['data']);
    }


    // 快捷返回数据处理
    protected function app_handle($data)
    {
        return $data['status'] ? $this->app_success($data['data']) : $this->app_error($data['data'], $data['msg']);
    }


    protected function app_success($data = [], $msg = "ok")
    {
        return ['status' => 200, 'message' => $msg, 'data' => $data];
    }

    protected function app_error($data = [], $msg = "ok")
    {
        return ['status' => 500, 'message' => $msg, 'data' => $data];
    }
}
