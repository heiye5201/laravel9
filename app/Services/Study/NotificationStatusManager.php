<?php

namespace App\Services\Study;

class NotificationStatusManager
{

    protected $extensions = [];

    // 注册扩展模块
    public function extend($name, \Closure $callback)
    {
        $this->extensions[$name] = $callback;
    }

    // 获取扩展模块
    public function driver($name)
    {
        if (!isset($this->extensions[$name])) {
            throw new \Exception("Extension {$name} not found.");
        }
        return $this->extensions[$name]();
    }
}
