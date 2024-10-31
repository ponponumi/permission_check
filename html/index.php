<?php

require_once __DIR__ . "/../vendor/autoload.php";

use Ponponumi\PermissionCheck\Get;

$get = new Get();

for ($i = -1; $i <= 8; $i++){
    var_dump($get->numToAlphabet(0));
}
