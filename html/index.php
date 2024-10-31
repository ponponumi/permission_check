<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\PermissionCheck\Get;

$get = new Get();

for ($i = -1; $i <= 8; $i++){
    var_dump($get->numToAlphabet($i));
}

var_dump($get->dataGet(__FILE__));                  // ファイルがある
var_dump($get->dataGet(__DIR__ . '/hello.txt'));    // ファイルがない
var_dump($get->myGet());                            // 自分の情報を取得
