<?php

//入口标记
define('ASINDEX',true);

//根目录路径常量
define('ROOT_PATH',str_replace('\\','/',dirname(__DIR__)).'/');

//加载初始化文件
include_once(ROOT_PATH.'core\App.php');

//开始初始化
\core\App::start();
