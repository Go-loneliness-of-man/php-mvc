<?php

$config = array(                         //各个配置项
  'database' => array(                   //数据库配置
    'type' => 'mysql',                   //数据库管理系统
    'host' => 'localhost',               //客户端主机
    'port' => '3306',                    //数据库端口
    'user' => 'root',                    //管理员账户
    'pwd' => '123',                      //密码
    'charset' => 'utf8',                 //编码
    'dbname' => '',                      //数据库名
    'prefix' => '',                      //表前缀
  ),

  'system'=>array(
    'error_reporting' => E_ALL,          //判断输出哪些错误处理，E_ALL 代表所有输出所有错误信息
    'display_errors' => 1                //是否显示错误信息
  )
);