<?php

// 命名空间
namespace core;
use core\dao;

// 抽象类，只能被继承，不能实例化
abstract class publicService {

  // 保存 dao 实例
  protected $dao;

  // 构造函数
  public function __construct() {

  }
}



