<?php

//命名空间
namespace core;

//安全判定，若请求不是来自入口文件，跳转回入口文件，defined() 判断一个常量是否存在
if(!defined('ASINDEX'))
{
  header('location:../public/index.php');            //跳转
  exit;                                              //退出
}

//创建初始化类
class App{
  //入口方法
  public static function start(){
    self::setPath();                                 //配置路径常量
    self::setConfig();                               //加载配置文件
    self::setError();                                //配置错误控制
    self::setUrl();                                  //解析 URL 分配路由
    self::setAutoLoad();                             //开启自动加载
    self::setDispath();                              //分发控制器
  }

  //定义路经常量，包括框架基本目录路径，各个模块的控制器模型视图目录路径。
  private static function setPath(){
    define('APP_PATH',          ROOT_PATH.'app/');
    define('CONFIG_PATH',       ROOT_PATH.'config/');
    define('CORE_PATH',         ROOT_PATH.'core/');
    define('VENDOR_PATH',       ROOT_PATH.'vendor/');
    define('HOME_PATH',         APP_PATH.'home/');
    define('ADMIN_PATH',        APP_PATH.'admin/');
    define('HOME_CONF',         HOME_PATH.'controller/');
    define('HOME_MOD',          HOME_PATH.'model/');
    define('HOME_VIEW',         HOME_PATH.'view/');
    define('ADMIN_CONF',        ADMIN_PATH.'controller/');
    define('ADMIN_MOD',         ADMIN_PATH.'model/');
    define('ADMIN_VIEW',        ADMIN_PATH.'view/');
    define('URL',               'http://mvc.com/');
  }

  //加载配置文件
  private static function setConfig(){
    global $config;                                 //声明全局变量 config
    include(CONFIG_PATH.'config.php');
  }

  //配置错误控制
  private static function setError(){
    global $config;                                 //引入全局变量 config 到当前函数作用域
    @ini_set('error_reporting',$config['system']['error_reporting']);  //判断输出哪些错误处理，E_ALL 代表所有输出所有错误信息
    @ini_set('display_errors',$config['system']['display_errors']);    //是否显示错误信息
  }

  //解析 URL 分配路由，p、c、a 依次代表模块、控制器、操作
  private static function setUrl(){
    if(empty($_REQUEST['p']))  $_REQUEST['p'] = 'home';                //默认 home 模块
    if(empty($_REQUEST['c']))  $_REQUEST['c'] = 'Index';               //默认 Index 控制器
    if(empty($_REQUEST['a']))  $_REQUEST['a'] = 'index';               //默认 index 操作
    define('P',$_REQUEST['p']);                     //定义模块、控制器、操作为常量
    define('C',$_REQUEST['c']);
    define('A',$_REQUEST['a']);
  }

  //自动加载类的方法，包括 core、模块的控制器和模型类、vendor 内的类文件，每次接收一个类名
  private static function setAutoLoadFunction($class){
    $class = basename($class);                      //去掉命名空间前缀，只保留类名
    $path = CORE_PATH.$class.'.php';                //加载核心类，core
    if(file_exists($path))  include_once($path);
    $path = APP_PATH.P.'/controller/'.$class.'.php';//加载模块控制器类
    if(file_exists($path))  include_once($path);
    $path = APP_PATH.P.'/model/'.$class.'.php';     //加载模块模型类
    if(file_exists($path))  include_once($path);
    $path = VENDOR_PATH.$class.'.php';              //加载插件类，vendor
    if(file_exists($path))  include_once($path);
  }
  //将方法注册到自动加载栈
  private static function setAutoLoad(){
    spl_autoload_register(array(__CLASS__,'setAutoLoadFunction'));
  }

  //分发控制器
  private static function setDispath(){
    $p = P;
    $c = C;
    $a = A;
    $controller = "core\\$p\\$c";                   //组成控制器名
    $c = new $controller();                         //实例化控制器
    $c->$a();                                       //调用对应操作
  }
}




