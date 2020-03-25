<?php

// 命名空间
namespace app\index\model;
use \core\publicModel;

class index extends publicModel{

    // protected $table = 'test';                                        // 覆盖默认表名
    // protected $dbname = 'test';                                       // 覆盖默认数据库

    public function index() {
        return '你调用了 index 模型的 index 方法';
    }
}



