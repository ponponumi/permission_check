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

    public function filePermissionGet(string $path)
    {
        // ファイルまたはフォルダからパーミッションを検索する
        // ファイルまたはフォルダがない場合は空の配列を返す
        $result = [];

        if(file_exists($path)){
            // ファイルまたはフォルダがあれば
            $perms = fileperms($path);
            $permOct = sprintf('%o',$perms);
            $result["num"] = substr($permOct,-3);

            // アルファベットを求める
            $list = str_split($result["num"]);
            $result["alphabet"] = "";

            foreach($list as $item){
                $result["alphabet"] .= $this->numToAlphabet($item);
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

    public function dataGet(string $path)
    {
        // 全ての情報を取得する
        $result = $this->filePermissionGet($path);

        if($result !== []){
            // 配列が空でなければ
            $owner = $this->ownerGet($path);
            $result = array_merge($result, $owner);
        }

        return $result;
    }

    public function myGet()
    {
        // 自分のデータを取得する
        $myId = posix_getuid();
        $myMeta = posix_getpwuid($myId);

        $result["myId"] = $myId;

        if($myMeta !== false){
            $result["myName"] = $myMeta["name"];
        }

        return $result;
    }
}
