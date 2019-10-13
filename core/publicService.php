<?php

// 命名空间
namespace core;

class publicService {
  //保存 doa 实例
  protected $dao;

  //保存当前表的所有字段，并单独保存主键
  protected $fields;

  //构造函数
  public function __construct(){

    //使用全局变量 $config
    global $config;

    //实例化 dao
    $this->dao = new Dao($config['database']);

  }
}



