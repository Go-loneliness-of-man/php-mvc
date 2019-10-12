<?php

// 命名空间
namespace core;

// 安全判定，若请求不是来自入口文件，跳转回入口文件，通过 defined() 判断一个常量是否存在
if(!defined('ASINDEX')) {
  header('location:../public/index.php');                 // 跳转至首页
  exit;                                                   // 退出
}

// 创建初始化类
class App{

  // 入口方法
  public static function start() {
    self::setPath();                                      // 定义路径常量
    self::setUrl();                                       // 解析 URL
    self::setConfig();                                    // 加载配置文件
    self::setError();                                     // 配置错误控制
    self::setPublicFunc();                                // 加载公共函数
    self::setAutoLoad();                                  // 开启自动加载
    self::setDispath();                                   // 分发控制器
  }

  // 定义路经常量，包括框架基本目录路径，各个模块的控制器模型视图目录路径。
  private static function setPath() {
    define('APP_PATH',    ROOT_PATH.'app/');              // 应用目录路径
    define('CONFIG_PATH', ROOT_PATH.'config/');           // 全局配置文件路径
    define('CORE_PATH',   ROOT_PATH.'core/');             // 框架核心目录
    define('VENDOR_PATH', ROOT_PATH.'vendor/');           // 插件目录
    define('PUBLICFUNC_PATH', ROOT_PATH.'publicFunc/');   // 公共函数目录
    define('URL',         'http://mvc.com/');             // 基本 URL
  }

  // 解析 URL 分配路由，M、C、A 依次代表模块（module）、控制器（controller）、操作（action）
  private static function setUrl() {
    $path = isset($_SERVER['PATH_INFO']) ? explode('/', $_SERVER['PATH_INFO']) : [];  // 切割路由
    $path = [
      'm' => isset($path[1]) ? $path[1] : 'index',        // 默认 index 模块
      'c' => isset($path[2]) ? $path[2] : 'index',        // 默认 index 控制器
      'a' => isset($path[3]) ? $path[3] : 'index'         // 默认 index 操作
    ];
    extract($path);                                       // 批量生成参数
    define('M', $m);                                      // 定义模块、控制器、操作为常量
    define('C', $c);
    define('A', $a);
  }

  // 加载配置文件
  private static function setConfig() {
    global $config;                                       // 声明全局变量 config
    include(CONFIG_PATH.'config.php');                    // 加载全局配置文件
    include(APP_PATH.M.'/config.php');                    // 加载模块配置文件
  }

  // 配置错误控制
  private static function setError() {
    global $config;                                       // 引入全局变量 config 到当前函数作用域
    @ini_set('error_reporting', $config['system']['error_reporting']);                // 判断输出哪些错误信息，E_ALL 代表所有输出所有错误信息
    @ini_set('display_errors', $config['system']['display_errors']);                  // 是否显示错误信息
  }

  // 加载公共函数
  private static function setPublicFunc() {
    global $config;                                       // 引入全局变量 config 到当前函数作用域
    for($i = 0, $c = count($config['publicFuncFile']); $i < $c; $i++)                 // 加载所有公共函数文件
      file_exists(APP_PATH.M.'/'.$config['publicFuncFile'][$i]) ?
      include_once(APP_PATH.M.'/'.$config['publicFuncFile'][$i]) :
      include_once(PUBLICFUNC_PATH.$config['publicFuncFile'][$i]);
  }

  // 自动加载类的方法，包括 core、模块的控制器和模型类、vendor 内的类文件，每次接收一个类名
  private static function setAutoLoadFunction($class) {
    $class = basename($class);                            // 去掉命名空间前缀，只保留类名

    // 加载核心类，core
    $path = CORE_PATH.$class.'.php';
    if(file_exists($path))  include_once($path);

    // 加载模块控制器
    $path = APP_PATH.M.'/controller/'.$class.'.php';
    if(file_exists($path))  include_once($path);

    // 加载模块模型
    $path = APP_PATH.M.'/model/'.$class.'.php';
    if(file_exists($path))  include_once($path);

    // 加载插件类，vendor
    $path = VENDOR_PATH.$class.'.php';
    if(file_exists($path))  include_once($path);
  }

  // 将自动加载方法注册到 php 内置的自动加载栈
  private static function setAutoLoad() {
    spl_autoload_register(array(__CLASS__, 'setAutoLoadFunction'));
  }

  // 分发控制器
  private static function setDispath() {
    $m = M;                                               // 取出便于拼接
    $c = C;
    $a = A;
    $controller = "\\app\\$m\\$c";                        // 组成控制器名
    $c = new $controller();                               // 实例化控制器
    $c->$a();                                             // 调用操作
  }
}




