<?php
// 测试
require './vendor/autoload.php';
use haveyb\TinyLaravel\database\MySQL;

$mysql = new MySQL();
echo $mysql->getDatabase();
echo 4;
