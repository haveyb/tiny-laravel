<?php
declare(strict_types = 1);

namespace haveyb\TinyLaravel\Application;

use haveyb\TinyLaravel\Container\Container;
use haveyb\TinyLaravel\Contracts\Database\DB;
use haveyb\TinyLaravel\Database\MySQL;
use haveyb\TinyLaravel\Database\Oracle;


/**
 * 框架核心，应用
 *
 * Class Application
 * @package haveyb\TinyLaravel\Application
 */
class Application extends Container
{
    public function __construct()
    {
        $this->registerBaseBindings();
        $this->registerBaseService();
    }

    /**
     * 注册系统运行所需要的服务
     */
    public function registerBaseService()
    {
        $bind = [
            'db' => MySQL::class,
            DB::class => Oracle::class
        ];
        foreach ($bind as $key => $value) {
            $this->bind($key, $value);
        }
    }

    /**
     * 事先绑定整个程序需要的共享实例（将自身绑定为共享实例）
     */
    public function registerBaseBindings()
    {
        $this->instance('app', $this);
        $this->instance(Container::class, $this);
    }

    /**
     * 从容器中解析实例
     *
     * @param $abstract `标识，可能是一个字符串，也可能是一个接口标识`
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function make($abstract, $parameters = [])
    {
        // 先判断是否在这个容器中
        if (!$this->has($abstract)) {
            return $abstract;
        }
        // 存在就去解析
        return parent::make($abstract, $parameters);
    }
}
