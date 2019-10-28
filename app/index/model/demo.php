<?php

// 命名空间
namespace app\index\model;
use \core\publicModel;

class demo extends publicModel{

    protected $table = 'mes';                                           // 覆盖默认表名

    // protected $dbname = 'mes';                                          // 覆盖默认数据库

    public function demo() {
        dump($this->table);
        dump($this->dbname);
        dump($this->fields);
    }
}



