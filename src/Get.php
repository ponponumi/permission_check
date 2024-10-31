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

    public function filePermissionGet(string $path,$alphabetMode=false)
    {
        // ファイルまたはフォルダからパーミッションを検索する
        // ファイルまたはフォルダがない場合は空文字を返す
        $result = "";

        if(file_exists($path)){
            // ファイルまたはフォルダがあれば
            $perms = fileperms($path);
            $permOct = sprintf('%o',$perms);
            $result = substr($permOct,-3);

            if($alphabetMode){
                // アルファベットモードが有効であれば
                $list = str_split($result);
                $result = "";

                foreach($list as $item){
                    $result .= $this->numToAlphabet($item);
                }
            }
        }

        return $result;
    }

    public function ownerGet(string $path)
    {
        // ファイルまたはフォルダの所有者と所有グループを取得する
        // ファイルまたはフォルダがない場合は空の配列を返す
        $result = [];

        if(file_exists($path)){
            // ファイルまたはフォルダがあれば
            $result["ownerId"] = fileowner($path);
            $result["groupId"] = filegroup($path);

            $ownerMeta = posix_getpwuid($result["ownerId"]);
            $groupMeta = posix_getpwuid($result["groupId"]);
            $result["ownerName"] = "";
            $result["groupName"] = "";

            if($ownerMeta !== false){
                $result["ownerName"] = $ownerMeta["name"];
            }

            if($groupMeta !== false){
                $result["groupName"] = $groupMeta["name"];
            }
        }

        return $result;
    }
}
