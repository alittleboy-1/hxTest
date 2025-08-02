<?php

namespace App\Common;

trait ResourceTrait
{
    protected $servicePath = "App\Services\\"; //强制大小写

    // 返回服务层地址
    protected function getService($serviceName = 'Users', $isModel = false, $servicePath = null)
    {
        if (!$servicePath) $servicePath = $this->servicePath;
        $serviceName = ucfirst($serviceName); // 大写首字母
        return app()->make($servicePath . $serviceName . 'Service');
    }

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
        // return ['code' => 200, 'msg' => $msg, 'data' => $data];
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
        return $data['status'] ? $this->success($data['data'], $data['msg']) : $this->error($data['msg'], $data['data']);
    }
}
