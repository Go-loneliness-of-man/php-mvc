<?php

namespace core;

class publicController{
  //构造函数
  public function __construct(){

  }

  //输出提示并跳转，参数是消息、模块、控制器、操作、时间，只有第一个是必选的
  protected function tips($msg, $p = P, $c = C, $a = A, $time = 15){
    $refresh = 'Refresh:'.$time.';url='.URL.'?p='.$p.'&c='.$c.'&a='.$a;
    header($refresh);
    echo $msg;
    exit;
  }

}



