<?php
namespace common\models;
use Yii;

/**
 * This is the model class for table "{{%wp_question_chapter}}".
 *
 * @property integer $id
 * @property integer $parentid
 * @property integer $status
 * @property string $name
 * @property integer $lft
 * @property integer $rgt
 * @property integer $root
 */
class Tag extends \yii\db\ActiveRecord
{

    public  static  function  getDb()
    {
        return Yii::$app->kdb;
    }

    public static function tableName()
    {
        return '{{%tag}}';
    }

    public function rules()
    {
        return [
            [['parentid', 'status', 'lft', 'rgt', 'root'], 'integer'],
            [['root'], 'required'],
            [['name'], 'string', 'max' => 128]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentid' => 'parentid',
            'status' => 'Status',
            'name' => 'Name',
            'lft' => 'Lft',
            'rgt' => 'Rgt',
            'root' => 'Root',
        ];
    }


    public  static  function getTagTree()
    {
        $data_chapter  =  Yii::$app->cache->get('data_chapter');
        $data_chapter =false;  //阻止缓存
        if(!$data_chapter)
        {
            $arr = self::find()->from('tag')->select('id,parentid,name,root,lvl,parents')->
            orderBy('root ,parentid,id')->
            asArray()->all();

            $data_chapter =  \common\utils\TreeUtils::list2tree($arr);
            Yii::$app->cache->set('data_chapter',$data_chapter);
        }

        return $data_chapter;
    }

    /***
     * 获取父章节字符串
     * @param $chapterid
     * @param int $treeid
     * @return array
     */
    public  static  function getChapterParents($chapterid , $treeid=1000)
    {
        $tree = self::getChapter();
        $tree = $tree[0];

        $result =  self::findNode($tree,$chapterid);
        array_push(self::$parents ,['id'=>$tree['id'],'name'=>$tree['name']] );

        return  self::$parents ;
    }

    /***
     * 获取章节的名称
     * @param $chapterid
     * @param int $treeid
     * @return bool
     */
    public  static  function getChapterNodeName($chapterid , $treeid=1000)
    {
        $tree = self::getChapter();
        $tree = $tree[0];
        $result =  self::findNode($tree,$chapterid);
        return  $result ;
    }


    public  static  $parents = [];

    /***
     *   *  获取树中某一个节点
     * @param $tree
     * @param $nodeId
     * @param int $lvl
     * @return bool
     */
    public  static  function  findNode($tree , $nodeId ,$lvl = 1 )
    {
          //echo $lvl;var_dump($tree);//
          if( $lvl==6 ) return  false;

          if(isset($tree['children']))
          foreach ($tree['children'] as $index=>$son)
          {
              //var_dump($son); exit();
              if($son['id']==$nodeId)
              {
                  array_push(self::$parents ,[ 'id'=>$son['id'] , 'name'=>$son['name'] ]);
                  return $son['name'];
              }else{
                  $res  =  self::findNode( $son , $nodeId , ++$lvl );
                  if($res)
                  {
                      array_push(self::$parents ,[ 'id'=>$son['id'] , 'name'=>$son['name'] ]);
                     return $res;
                  }
              }

          }

          return false;
    }

    /****
     * 获取指定级别的标签 ---用于给文章添加标签
     * @param $lvl
     */
    public  static  function  getTagsByLvl($lvl)
    {
        $sql = "select * from  tag where lvl =1";
      //return  Yii::$app->db->createCommand($sql)->queryAll();
       $data= self::find()->where(['lvl'=>$lvl,'status'=>1])->asArray()->all();

      return  $data;
    }

    /***
     * 获取顶层标签
     * @return array|
     */
    public static  function getLvl1Tag()
    {
        $arr = self::find()->select('id , name as text')->
        where( ['lvl'=>1 , 'status'=>1] )->
        asArray()->all();
        return $arr ;
    }
    /***
     * 获取父标签下面的子标签
     * @param $chapterid
     * @param int $treeid
     * @return bool
     */
    public  static  function  getTagsByParent($parentid)
    {
        $arr = self::find()->select('id , name as text')->
        where( ['parentid'=>$parentid , 'status'=>1] )->
        asArray()->all();
        return $arr ;
    }

    /***
     * 缓存标签信息
     * @return array|mixed
     */
    public  static function   getTagMap()
    {
        $tags =Yii::$app->cache->get('tag_map');
        if(empty($tags))
        {
            $tags = [];
            $tagsT = self::find()->select("id , name as title")->asArray()->all();
            foreach ($tagsT as $val)
            {
                $tags[$val['id']] = $val['title'];
            }
            Yii::$app->cache->set('tag_map' , $tags , 3600);
        }

        return  $tags;
    }

    /***
     * 获取一个字符串的最后一个id 对应的标签名称
     * @param $tagStr
     * @return mixed|string
     */
    public  static function   getLastTagName($tagStr)
    {
        $ids = explode(',' , $tagStr);
        $id =array_pop($ids);
        if( !intval($id) )  return '选择标签';
        //echo $id;
        $tagMap = self::getTagMap();

        return isset($tagMap[$id]) ? $tagMap[$id] : '--';
    }

}
