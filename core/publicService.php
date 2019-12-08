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

  // 标准返回格式
  public function res($code, $message, $result, $total = 0) {
    return json_encode([
      'code' => $code,
      'message' => $message,
      'result' => $result,
      'total' => $total === 0 ? null : $total
    ]);
  }
}



