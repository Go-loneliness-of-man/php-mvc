<?php

// 全局配置数组
$config = [

  // 数据库配置
  'database' => [
    'type' => 'mysql',                   // 数据库管理系统
    'host' => 'localhost',               // 客户端主机
    'port' => '3306',                    // 数据库端口
    'user' => 'root',                    // 管理员账户
    'pwd' => '123',                      // 密码
    'charset' => 'utf8',                 // 编码
    'dbname' => 'myboard',               // 数据库名
    'front' => '',                       // 表前缀
    'behind' => '',                      // 表后缀
  ],

  // 系统配置
  'system' => [
    'error_reporting' => E_ALL,          // 判断输出哪些错误处理，E_ALL 代表所有输出所有错误信息
    'display_errors' => 1                // 是否显示错误信息
  ],

  // 配置公共函数文件
  'publicFuncFile' => [
    'public.php'
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

