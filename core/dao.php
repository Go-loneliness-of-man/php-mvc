<?php

// 命名空间
namespace core;
use \PDO;
use \PDOStatement;
use \PDOException;

class Dao{

  //保存 pdo 对象
  private $pdo;

  //构造函数
  public function __construct($db) {

    //配置数据库基本信息
    $type    =  empty($db['type'])      ?     'mysql'       :    $db['type'];       // DBMS
    $host    =  empty($db['host'])      ?     'localhost'   :    $db['host'];       // 主机名
    $port    =  empty($db['port'])      ?     '3306'        :    $db['port'];       // 端口号
    $user    =  empty($db['user'])      ?     'root'        :    $db['user'];       // 数据库管理员帐号名
    $pwd     =  empty($db['pwd'])       ?     '123'         :    $db['pwd'];        // 数据库管理员帐号密码
    $charset =  empty($db['charset'])   ?     'utf8'        :    $db['charset'];    // 编码类型
    $dbname  =  empty($db['dbname'])    ?     ''            :    $db['dbname'];     // 数据库名
    $prefix  =  empty($db['prefix'])    ?     ''            :    $db['prefix'];     // 表前缀

    //实例化 PDO 对象
    try{
      $this->pdo = new PDO($type.':host='.$host.';port='.$port.';dbname='.$dbname, $user, $pwd);    //实例化
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);           //异常处理
    }
    catch(PDOException $e)
    {
      echo '数据库连接失败<br>错误文件为：'.$e->getFile().'<br>错误行为：'.$e->getLine.'错误描述：'.$e->getMessage();
      exit;
    }
  }

  // sql 构造器，构造 SELECT
  public function select($params) {
    $sql = '';                                                                      // 存储 sql
    extract(params);                                                                // 批量生成参数

  }


}

/*
/*  ***************************************************************** 以下为统计分析模块公共服务 ************************************************************************
      sql 构造器，支持大多数 sql 关键字，采用对象传参，基于关键字设计参数，可选择直接返回生成好的 sql 语句（用于实现子查询、调试）。目前支持三个方法，select()、one()、define()，
      作用依次是查询、查询一条、预定义查询（是在函数内配置好的对象，使用时可直接调用）
      auth: wanghcao

  **  select(): 用于构造 SELECT 语句，参数如下。
  **  field:    string                                                                      必须，要获取的字段
  **  form:     string 或 [[ string, string, string, string ], [ string, string, string ]]  必须，数据源，当传入数组时会自动进行关联查询，关联查询时，第一个为表 1、表2、条件、关联类型（可选，默认 left join），之后为表名、条件、关联类型（可选）
  **  where:    string 或 [[ string, string, string ], [ string, string, string]]           可选，where 子句，每个子数组依次是左值、关系运算符和右值、逻辑运算符（可选，默认 AND）
  **  group:    string                                                                      可选，分组
  **  distinct: bool                                                                        可选，是否去重
  **  order:    string                                                                      可选，用于排序的字段名
  **  limit:    [ number, number ]                                                          可选，获取的记录区间，可以只传一个
  **  onlySql: bool                                                                         可选，是否直接返回 sql 字符串

  **  one():  专用于查询单条记录，参数与 select() 相同。

  **  define(): 用于定义、执行预定义对象。
  **  key:                                                                                   必须，预定义对象在 hash 中的 key
  **  params:                                                                                可选，其属性是预定义对象需要的参数，其内多了个属性 one，用于判断调用 one() 还是 select()
  **  cover:                                                                                 可选，用于覆盖预定义对象的属性，使其更加灵活

  // 查询一条
  async one(params) {
    return params.onlySql ? await this.ctx.service['survey'].select(params) : (await this.ctx.service['survey'].select(params))[0];
  }

  // 预定义查询
  async define(key, params = {}, cover = {}) {
    let { community_id, start, end, one, tag } = params, { app, ctx } = this;

    // 保存预定义对象的 hash
    let hash = {

      // 获取小区下的所有楼
      building: {
        field: `*`,
        from: `wh_info_building_t`,
        where: `community_id = ${community_id}`
      },

      // 获取小区下的所有房间
      community_house:{
        field: `*`,
        from: `wh_info_heat_user_v`,
        where: `community_id = ${community_id}`
      },

      // 获取该小区下所有楼在 start、end 间的数据
      buildingDaily: {
        field: `
          b.building_name AS building_name,
          dd.avg_data AS avg_data,
          dd.data_time AS data_time`,
        from: [
          [`wh_info_building_t b`, `wh_daily_data_t dd`, `b.building_id = dd.entity_id`]
        ],
        where: [
          [`b.community_id`, ` = ${community_id}`],
          [`dd.entity_type`, ` = 4`],
          [`tag_id`, ` = ${tag}`],
          [`data_time`, ` >= '${start}'`],
          [`data_time`, ` <= '${end}'`]
        ]
      },

      // 获取小区下的所有分区，将小区、楼、单元、分区表关联进行查找
      controller: {
        field: `
          b.building_id AS building_id,
          b.building_name AS building_name,
          u.unit_number AS unit_number,
          con.water_loop AS water_loop,
          con.controller_id AS controller_id`,
        from: [
          [`wh_info_community_t c`, `wh_info_building_t b`, `c.community_id = b.community_id`],
          [`wh_info_unit_t u`, `b.building_id = u.building_id`],
          [`wh_info_controller_t con`, `con.unit_id = u.unit_id`],
        ],
        where: `c.community_id = ${community_id}`,
        order: `con.controller_id`
      }
    };

    // 覆盖部分参数
    for(let k in cover) {
      hash[key][k] = cover[k];
    }

    // 返回结果
    return one ? await ctx.service['survey'].one(hash[key]) : await ctx.service['survey'].select(hash[key]);
  }

  // 根据 start、end 生成一段连续的日期，以数组形式返回
  async date(start, end) {
    let { app } = this, time = [];
    for(let date = start; date !== end; date = app.addOneDate(date))
      time[time.length] = date;
    time[time.length] = end;

    // 返回结果
    return time;
  }

*/

