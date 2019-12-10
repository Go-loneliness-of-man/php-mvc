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

  // 常用代码片段，增，参数依次是模型、消息、要插入的数据（关联数组）
  public function oftenC($model, $message = 'success', $body) {
    $res = $model->create($body);                                                          // 插入记录
    return $this->res(200, $message, $res);                                                // 返回固定格式
  }

  // 常用代码片段，删，参数依次是模型、消息、删除条件
  public function oftenD($model, $message = 'success', $where) {
    $res = $model->delete($where);                                                         // 删除记录
    return $this->res(200, $message, $res);                                                // 返回固定格式
  }

  // 常用代码片段，改，参数依次是模型、消息、修改对象、修改条件
  public function oftenU($model, $message = 'success', $obj, $where) {
    foreach($obj as $k => $v)                                                              // 遍历修改所有属性
      $res = $model->update($k, $v, $where);
    return $this->res(200, $message, $res);                                                // 返回固定格式
  }

  // 常用代码片段，查，参数依次是模型、消息、id 列表
  public function oftenR($model, $message = 'success', $list = []) {
    if(count($list) > 0)
      $res = $model->get($list);
    else
      $res = $model->dao->query("SELECT * FROM $model->dbname.$model->table");
    return $this->res(200, $message, $res);                                                // 返回固定格式
  }
}



