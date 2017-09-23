<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Album]].
 *
 * @see Album
 */
class MaterialQuery extends \yii\sphinx\ActiveRecord
{
    public  $error;

    public  static function  indexName()
    {
        return "material";
    }

    /**
     * @inheritdoc
     * @return Exam[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Exam|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public static function  getMaterialList($param = array())
    {
        //\common\utils\Log::info($param);
        if(empty($param)){
            $param = \Yii::$app->request->get();
        }

        isset($param['pagesize'] ) ? $pagesize = intval($param['pagesize']):$pagesize=10;
        if($pagesize>30) $pagesize=30;
        isset($param['page']) ? $page = intval($param['page']):$page=1;

        $query = self::find();
        $query->from('material');
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        if(isset($param['tag']))
            $query->andWhere(" tag in ({$param['tag']}) ");
       // if(isset($param['node_id']))
          //  $query->andWhere(" node_id = {$param['node_id']}"  );
        if(isset($param['chapter']))
            $query->andWhere("chapter in ({$param['chapter']})");

        $query->limit($pagesize); //($page-1)*$pagesize

        $sql= $query->createCommand()->getRawSql();
        // \common\utils\Log::info( $sql);

        $data= \Yii::$app->sphinx->createCommand($sql)->queryAll();

        $condition['status'] = 1;
        $total = $query->count();
        $param['currentPage']= $page;
        $param['total']    = $total;
        $param['pagesize'] =$pagesize;
        return ['data'=>$data , 'param'=>$param];
    }

    //
    public static  function getCarousel()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
       // \common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
       // \common\utils\Log::info($data);

        return $data;
    }
    //最热
    public static function  getHot()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        //\common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
       // \common\utils\Log::info($data);

        return $data;
    }

    //获取最热用户
    public  static  function  getHotUser()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        //\common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        //\common\utils\Log::info($data);

        return $data;
    }

    //最新
    public static function  getLast()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        //\common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        //\common\utils\Log::info($data);

        return $data;
    }

}