<?php
declare(strict_types = 1);

namespace haveyb\TinyLaravel\Facades;

// 快速调用
class Storage extends Facade
{
    // 重写抽象父类方法
    public static function getFacadeClass()
    {
        return 'storage';
    }


}