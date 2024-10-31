<?php

namespace Ponponumi\PermissionCheck;

class Get
{
    public array $numToalphabetData = [
        "---",
        "--x",
        "-w-",
        "-wx",
        "r--",
        "r-x",
        "rw-",
        "rwx",
    ];

    public function numToAlphabet($num)
    {
        $num = intval($num);

        if($num >= 1 && $num <= 7){
            return $this->numToalphabetData[$num];
        }else{
            return $this->numToalphabetData[0];
        }
    }
}
