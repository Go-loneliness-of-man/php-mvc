<?php

// 递归解析变量为字符串，参数 $s、$var、$h 依次是待输出字符串、待解析变量、当前递归深度
function recursiveOutputVariable($s, $var, $h) {
    $type = gettype($var);                                               // 获取变量类型

    // 生成空白符
    $space = '';
    for($i = 0; $i < $h; $space = $space.'    ', $i++);

    // 解析对象、数组
    if($type === 'object' || $type === 'array') {
        $s = $h === 1 ? "$s$space"."$type(<br>" : $s."$type(<br>";
        $i = 0;                                                          // 判断循环次数
        foreach($var as $k => $v) {                                      // 遍历对象属性
            if(gettype($v) === 'object' || gettype($v) === 'array') {    // 判断属性值是否是对象、数组
                $s = "$s<br>    $space$k => ";
                $s = recursiveOutputVariable($s, $v, ++$h);              // 是对象、数组，进行递归
            }
            else                                                         // 简单类型
                $s = $i === 0 ? $s."    $space$k => ".gettype($v)." ($v)" : $s."<br>    $space$k => ".gettype($v)." ($v)";
            $i++;
        }
        $s = $s."<br>$space)";
    }
    else
        $s = "$s    $space$type ($var)";
    return $s;
}

// 格式化输出变量，便于调试查看
function dump($var, $name = '') {
    $name = $name === '' ? '' : "    $$name :<br>";
    $s = "<pre>$name";
    $s = recursiveOutputVariable($s, $var, 1);                           // 递归解析变量为字符串
    echo $s.'</pre>';
}



