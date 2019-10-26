<?php

// 全局配置数组
$config = [

  // 数据库配置
  'database' => [

    // 数据库管理系统
    'type' => 'mysql',

    // 客户端主机
    'host' => 'localhost',

    // 数据库端口
    'port' => '3306',

    // 管理员账户
    'user' => 'root',

    // 密码
    'pwd' => '123',

    // 编码
    'charset' => 'utf8',

    // 数据库名
    'dbname' => '',

    // model 的表名前缀
    'front' => '',

    // model 的表名后缀
    'behind' => ''
  ],

  // 系统配置
  'system' => [

    // 判断输出哪些错误处理，E_ALL 代表所有输出所有错误信息
    'error_reporting' => NULL,

    // 是否显示错误信息
    'display_errors' => 1
  ],

  // 配置公共函数文件
  'publicFuncFile' => [
    'public.php'// 系统函数，必须加载
  ],

  // 项目 URL
  'URL' => [
    'http://rw.com/'
  ],

  // 配置中间件，执行顺序与数组顺序相同，每个元素依次是类名、方法名
  'middlewareFile' => [
    ['test', 'testFunc']
  ],
];

