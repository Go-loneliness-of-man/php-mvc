<?php

// 命名空间
namespace app\index\controller;
use \core\publicController;
use \app\index\service\demo;
use \plugIn\test;

class index extends publicController {

  public function index() {
    $service = new demo();
    return '控制器 index，调用服务 demo<br>'.$service->demo();
  }

  public function plugIn() {
    $plugIn = new test();
    return $plugIn->test();
  }

  public function test() {
    dump($this->get());
    return '';
  }
}

