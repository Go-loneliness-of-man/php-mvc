<?php

// 命名空间
namespace app\index\controller;
use \core\publicController;
use \app\index\service\index as service;           // service
use \plugIn\test;                                  // 插件

class index extends publicController {

  // 基本流程示例
  public function index() {
    $service = new service();
    $params = $this->get();
    return '控制器 index 的 index 操作，调用了服务 index 的 index 方法<br>'.$service->index($params);
  }

  // 简化流程示例
  public function easy() {
    $service = new service();
    $params = $this->get();
    return '控制器 index 的 index 操作，调用了服务 index 的 index 方法<br>'.$service->index($params);
  }

  // 插件示例
  public function plugIn() {
    $plugIn = new test();
    return $plugIn->test();
  }

  // 模板示例
  public function template() {
    $a = '变量 a';
    $b = '变量 b';
    $this->loadVar('a', $a);
    $this->loadVar('b', $b);
    $this->show('demo');
  }
}

