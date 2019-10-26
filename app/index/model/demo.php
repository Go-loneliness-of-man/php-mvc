<?php

// 命名空间
namespace app\index\model;
use app\core\publicModel;

class demo extends publicModel{

    protected $table = '123';// 覆盖默认表名

    public function demo() {
        dump($this->table);
        dump($this->dbname);
    }
}



