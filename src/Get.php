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

    public function alphabetToNum(string $permission,$default=null)
    {
        // 一致しない場合はデフォルトを返す
        $result = array_search($permission, $this->numToalphabetData);

        if($result !== false){
            return $result;
        }

        return $default;
    }
}
