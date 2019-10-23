<?php

// 命名空间
namespace core;

// 抽象类，只能被继承，不能实例化
abstract class publicController {

  // 输出提示并跳转，参数是消息、模块、控制器、操作、时间，只有第一个是必选的
  protected function jump($msg, $m = M, $c = C, $a = A, $time = 5, $params = []) {
    global $config;
    $refresh = 'Refresh:'.$time.';url='.$config['URL'][0]."$m/$c/$a?params=".json_encode($params);  // 拼接请求头
    header($refresh);                                       // 跳转
    echo $msg;                                              // 输出消息
    exit;
  }

  // 参数校验，参数依次是规则、请求参数
  protected function rule($rule, $params) {
    foreach($rule as $k => $v)
      if(gettype($params[$k]) !== $v) {
        echo '参数错误，参数 '.$k.' 应为 '.$v;
        exit;
      }
  }

  // 获取请求参数，默认进行类型转换
  protected function get($isJson = 0, $convert = 1) {
    $res = [];                                              // 准备结果
    if(!$isJson && $convert)                                // 不是 json 且转换
      foreach($_REQUEST as $k => $v) {                      // 遍历请求参数
        if(!preg_match_all('/[\D]+/', $v))                  // 检测字符串中是否仅包含数字，若是则转换
          $res[$k] = intval($v);                            // 转换为数值并赋值
        else
          $res[$k] = $v;                                    // 字符串，直接赋值
      }
    else if($isJson)                                        // 是 json
      foreach($_REQUEST as $k => $v)                        // 遍历请求参数
        $res[$k] = json_decode($v);                         // 转换一次
    return $isJson ? $res : ($convert ? $res : $_REQUEST);  // 若是 json 或需要类型转换则返回 $res，否则返回 $_REQUEST
  }
}



