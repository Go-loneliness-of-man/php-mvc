<?php

$admin = [                              // 各配置项

];

// 覆盖全局 config 的部分参数
foreach($admin as $k => $v) {
  $config[$k] = $admin[$k];
}
