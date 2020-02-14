<?php
declare(strict_types = 1);

namespace haveyb\TinyLaravel\Facades;

// 门面的主要作用是便于维护，方便调用
use haveyb\TinyLaravel\Application\Application;

abstract class Facade
{
    protected static $resolvedInstance = [];

    /**
     * 由子类重写，且必须重写
     *
     * @throws \Exception
     */
    public static function getFacadeClass(){
        throw new \Exception('你没有指定代理的门面类', 1);
    }

    /**
     * 获取这个要调用的这个类
     *
     * @return mixed|void
     * @throws \Exception
     */
    public static function createFacade()
    {
        // 找到这个类
        $class = static::getFacadeClass();
        if (is_object($class)) {
            return $class;
        }
        // 判断是否之前存在
        if (isset(static::$resolvedInstance[$class])) {
            return static::$resolvedInstance[$class];
        }
        // 创建这个类
        // return static::$resolvedInstance[$class] = $app[$class]
        return static::$resolvedInstance[$class] = Application::getInstace()->make($class);
    }

    /**
     *
     * @param $method
     * @param $args
     * @return mixed
     * @throws \Exception
     */
    public static function __CallStatic($method, $args)
    {
        // ... 新特性解释 http://php.net/manual/zh/migration56.new-features.php
        // 1. 获取这个要调用的这个类
        $class = static::createFacade();
        var_dump($class);
        if (!$class) {
            throw new \Exception("类没有找到 ".$class, 1);
        }
        // 2. 执行这个类了吗
        return $class->{$method}(...$args);
    }

}