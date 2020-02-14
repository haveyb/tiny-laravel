<?php
declare(strict_types = 1);

require './vendor/autoload.php';

use haveyb\TinyLaravel\Application\Application;

// 获取应用核心
$app = new Application();

echo \haveyb\TinyLaravel\Facades\Storage::getFacadeClass();
die;


// 测试
$db = $app->make('db');
echo $db->getDatabase();




