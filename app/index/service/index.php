<?php

// 命名空间
namespace app\index\service;
use \core\publicService;
use \app\index\model\index as model;

class index extends publicService {

    public function index($params) {
        // $model = new model(); // 若数据库内没有与 model 对应的表，会报错
        // dump($model->index());
        dump($params);
    }
}



