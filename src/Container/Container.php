<?php
declare(strict_types = 1);

namespace haveyb\TinyLaravel\Container;

/**
 * 容器
 *
 * Class Container
 * @package haveyb\TinyLaravel\Container
 */
class Container
{
    // 绑定数组
    protected $bind = [];

    // 用于指定当前的实例，单例
    protected static $instance;

    // 实例数组，保存从容器解析出的实例，共享，避免重复创建
    protected $instances;

    /**
     * 用于容器的绑定操作
     *
     * @param $abstract
     * @param $object
     */
    public function bind($abstract, $object)
    {
        $this->bind[$abstract] = $object;
    }

    /**
     * 校验是否存在于容器中
     *
     * @param $abstract
     * @return bool
     */
    public function has($abstract)
    {
        return isset($this->bind[$abstract]);
    }

    /**
     * 将实例共享
     *
     * @param $abstract `标识`
     * @param $instance `实例`
     */
    public function instance($abstract, $instance)
    {
        // 判断是否存在该实例，如果已经存在该实例，则先删除原绑定关系
        if (isset($this->bind[$abstract])) {
            unset($this->bind[$abstract]);
        }
        // 绑定
        $this->instances[$abstract] = $instance;
    }

    /**
     * 单例模式
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static;
        }
        return static::$instance;
    }

    /**
     * 解析实例
     *
     * @param $abstract
     * @param array $parameters
     * @return mixed
     * @throws \Exception
     */
    public function make($abstract, $parameters = [])
    {
        // 判断之前是否已经从容器中解析出，如果存在实例就直接返回
        if (isset($this->instances[$abstract])) {
            return $this->instances[$abstract];
        }
        // 判断是否已经绑定，如果已经绑定，则将绑定的对应实例放到实例数组中共享，并返回实例
        if (isset($this->bind[$abstract])) {
            $class = $this->bind[$abstract];
            $object = (empty($parameters)) ? new $class() : new $class(...$parameters);
            return $this->instances[$abstract] = $object;
        }
        throw new \Exception('没有找到对应的实例 '.$abstract, 1);
    }

}

