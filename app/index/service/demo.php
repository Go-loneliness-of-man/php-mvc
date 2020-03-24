<?php

// 命名空间
namespace app\index\service;
use \core\publicService;
use \app\index\model\demo as demoModel;

class demo extends publicService {

    public function demo() {
        $model = new demoModel();
        return '你调用了服务 demo，服务 demo 调用了模型 demo<br>'.$model->demo();
    }
}



