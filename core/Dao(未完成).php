<?php

namespace core;
use \PDO;
use \PDOStatement;
use \PDOException;

class Dao{
  //保存 pdo 对象
  private $pdo;

  //构造函数
  public function __construct($db){
    //配置数据库基本信息
    if(empty($db['type']))      $type = 'mysql';                           //DBMS
    else                        $type = $db['type'];
    if(empty($db['host']))      $host = 'localhost';                       //主机名
    else                        $host = $db['host'];
    if(empty($db['port']))      $port = '3306';                            //数据库通信端口
    else                        $port = $db['port'];
    if(empty($db['user']))      $user = 'root';                            //用户名
    else                        $user = $db['user'];
    if(empty($db['pwd']))       $pwd = '123';                              //用户密码
    else                        $pwd = $db['pwd'];
    if(empty($db['charset']))   $charset = 'utf8';                         //编码
    else                        $charset = $db['charset'];
    if(empty($db['dbname']))    $dbname = '';                              //数据库名
    else                        $dbname = $db['dbname'];
    if(empty($db['prefix']))    $prefix = '';                              //表前缀
    else                        $prefix = $db['prifix'];

    //实例化 PDO 对象
    try{
      $this->pdo = new PDO($type.':host='.$host.';port='.$port.';dbname='.$dbname, $user, $pwd);    //实例化
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  //异常处理
    }
    catch(PDOException $e)
    {
      echo '数据库连接失败<br>错误文件为：'.$e->getFile().'<br>错误行为：'.$e->getLine.'错误描述：'.$e->getMessage();
      exit;
    }
  }


}



