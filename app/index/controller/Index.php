<?php

// 命名空间
namespace app\index\controller;
use app\core\publicController;
use app\index\model\demo;

class index extends publicController {

  public function index() {
    $model = new demo();
    $model->demo();
    return 1;
  }

  public function test() {
    dump($this->get());
    return '';
  }
}

