<?php

// 命名空间
namespace app\core;
use app\core\dao;

// 抽象类，只能被继承，不能实例化
abstract class publicModel extends dao{

  // 保存当前表的所有字段，并单独保存主键
  protected $fields;

  // 保存表名
  protected $table = '';

  // 保存数据库名
  protected $dbname = '';

  //构造函数
  public function __construct(){
    global $config;                                                                         // 引入全局变量 $config

    // 数据库名
    $this->dbname = $this->dbname === ''                                                    // 设置子类数据库
    ? $config['database']['dbname']                                                         // 子类未进行覆盖，读取配置文件
    : $this->dbname;                                                                        // 子类进行了覆盖，不进行重新赋值

    // 表名
    $table = convertNaming(basename(get_class($this)));                                     // 获取子类名并将小驼峰转换为小写下划线
    $this->table = $this->table === ''                                                      // 保存子类 model 所映射的表名
    ? $config['database']['front'].$table.$config['database']['behind']                     // 子类未进行覆盖，采用子类名的小写下划线
    : $this->table;                                                                         // 子类进行了覆盖，不进行重新赋值

    // 获取表字段
    $this->fields = 2;
  }
}



