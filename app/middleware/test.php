<?php

namespace app\middleware;

class test {

    public static function testFunc($request = []) {
        dump('中间件打印了请求参数：');
        dump($request);
    }
}
