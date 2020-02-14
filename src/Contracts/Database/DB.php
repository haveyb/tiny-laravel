<?php
declare(strict_types = 1);

namespace haveyb\TinyLaravel\Contracts\Database;

/**
 * 选择接口而不选择抽象类，最主要的原因是抽象类是单继承，接口是多继承
 *
 * Interface DB
 * @package haveyb\TinyLaravel\Contracts\Database
 */
interface DB
{
    public function getDatabase();

    public function showDev();

}