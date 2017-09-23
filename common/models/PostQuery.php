<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Album]].
 *
 * @see Album
 */
class PostQuery extends \yii\db\ActiveRecord  #\yii\sphinx\ActiveRecord
{
    public  $error;

    public  static function  indexName()
    {
        return "post";
    }

    public  function  rules()
    {
        return [
            [['id','uid', 'status','node_id'],'integer' , 'message'=>'非法数据'] ,
            [['cover','tag','chapter'] ,'string','max'=>128 , 'message'=>'标题太长'],
            //[['desc'] , 'string', 'max'=>256, 'message'=>'描述太长'],
        ];
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

    public static function  getPostList($param = array())
    {
        //\common\utils\Log::info($param);
        if(empty($param)){
            $param = \Yii::$app->request->get();
        }
        isset($param['pagesize'] ) ? $pagesize = intval($param['pagesize']):$pagesize=10;
        if($pagesize>30) $pagesize=30;

        $maxId = isset($param['maxMsgId']) ? $maxId =$param['maxMsgId']:$maxId = 0 ;

        $query = self::find();
        $query->from('post');
        $query->select("id, chapter ,content")->limit($pagesize);
        $query->where("id > {$maxId}");
        $query->orderBy("id desc");
        if(isset($param['chapter']))
            $query->andWhere("chapter in ({$param['chapter']})");

        $query->limit($pagesize); //($page-1)*$pagesize
        $data = $query->createCommand()->queryAll();
        $sql= $query->createCommand()->getRawSql();
        //echo $sql;
        //\common\utils\Log::info( $sql);
        $data = array_reverse($data);
        $condition['status'] = 1;
        $total = $query->count();
        $param['total']    = $total;
        return ['data'=>$data , 'param'=>$param];
    }

    //
    public static  function getCarousel()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        \common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        \common\utils\Log::info($data);

        return $data;
    }
    //最热
    public static function  getHot()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        \common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        \common\utils\Log::info($data);

        return $data;
    }

    //获取最热用户
    public  static  function  getHotUser()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        \common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        \common\utils\Log::info($data);

        return $data;
    }

    //最新
    public static function  getLast()
    {
        $query = self::find();
        $query->select("id,title,create_time,tag,chapter")->limit(10);
        $query->andWhere('status = 1 ');
        $sql =  $query->createCommand()->getRawSql();
        \common\utils\Log::info($sql);
        $data=  $query->asArray()->all();
        \common\utils\Log::info($data);

        return $data;
    }

}