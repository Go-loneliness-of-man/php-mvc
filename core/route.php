<?php

// 命名空间
namespace core;

// 实现路由注册
class route {

    // 先遍历路由注册表，若存在匹配路由，取出其模块、控制器、操作
    public static function router($path) {
        global $route;                                       // 声明全局变量 route
        include(CONFIG_PATH.'route.php');                    // 读取路由配置文件
        self::params($route, $path);                         // 解析 params 参数到 $_REQUEST
        for($i = 0, $c = count($route); $i < $c; $i++)       // 遍历查找匹配的路由
            if($route[$i][0] === $path) {                    // 若匹配，则定义模块、控制器、操作为常量
                define('M', $route[$i][1]);                  // 默认 index 模块
                define('C', $route[$i][2]);                  // 默认 index 控制器
                define('A', $route[$i][3]);                  // 默认 index 操作
                return 0;                                    // 已匹配，不进行默认路由
            }
        return 1;                                            // 无匹配路由，进行默认路由
    }

    // 解析 params 参数到 $_REQUEST
    public static function params($route, $path) {
        1;
    }
}

