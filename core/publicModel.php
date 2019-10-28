<?php

// 命名空间
namespace core;
use core\dao;

// 抽象类，只能被继承，不能实例化
abstract class publicModel {

  protected $dao;                                                                           // 保存 dao 实例
  protected $dbname = '';                                                                   // 保存数据库名
  protected $table = '';                                                                    // 保存表名
  protected $struct;                                                                        // 保存表名
  protected $fields;                                                                        // 保存当前表的所有字段
  protected $primaryKey = '';                                                               // 单独保存主键

  // 构造函数
  public function __construct() {
    $this->dao = dao::get();                                                                // 保存 dao 实例的引用到 model

    // 数据库名
    $this->dbname = $this->dbname === ''                                                    // 设置子类数据库
    ? $this->dao->dbname                                                                    // 子类未进行覆盖，从 dao 获取
    : $this->dbname;                                                                        // 子类进行了覆盖，不进行重新赋值

    // 表名
    $table = convertNaming(basename(get_class($this)));                                     // 获取子类名并将小驼峰转换为小写下划线
    $this->table = $this->table === ''                                                      // 保存子类 model 所映射的表名
    ? $this->dao->front.$table.$this->dao->behind                                           // 子类未进行覆盖，采用子类名的小写下划线
    : $this->table;                                                                         // 子类进行了覆盖，不进行重新赋值

    // 保存表的创建语句
    $this->struct = ($this->dao->one('show create table '.$this->dbname.'.'.$this->table))['Create Table'];

    // 保存表的所有字段
    preg_match_all('/ `([a-z,A-Z,_]{1, 30})` [^(]./', $this->struct, $fields, PREG_PATTERN_ORDER);    // 取出数据表所有字段
    $this->fields = $fields[1];                                                             // 保存字段到 model

    // 保存表的主键
    preg_match_all('/ `([a-z,A-Z,_]{1, 30})` /', $this->struct, $fields, PREG_PATTERN_ORDER);         // 取出数据表的主键
    $this->fields = $fields[1];                                                             // 保存字段到 model
  }

  // 插入记录，返回主键，若不存在主键则返回插入条数，$data 是一维关联数组时插入一条，是二维关联数组时插入多条
  public function create($data) {
    $count = 0;
    if(is_array($data[0])) {                                                                // 插入多条

    }
    else {                                                                                  // 插入单条

    }
    return '';
  }

  // 删除记录，返回删除条数，$where 为关联数组，作为删除的判断条件
  public function delete($where) {
    $count;

    return '';
  }

  // 修改记录，返回修改条数，$key、$value 为修改的字段名、值，$where 为关联数组，作为修改的判断条件
  public function update($key, $value, $where) {
    $count;

    return '';
  }

  // 根据主键查询记录，只需要传值，不需要传字段名
  public function get($primaryKey) {
    if(is_array($primaryKey)) {                                                             // 查询多条

    }
    else {                                                                                  // 查询单条

    }
    return '';
  }
}



