<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Chapter;

/**
 * ChapterSearch represents the model behind the search form about `common\models\Chapter`.
 */
class ChapterSearch extends Chapter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'root', 'lvl', 'categoryId', 'parentId', 'cover', 'status', 'order'], 'integer'],
            [['parents', 'title', 'desc', 'category'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Chapter::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'root' => $this->root,
            'lvl' => $this->lvl,
            'categoryId' => $this->categoryId,
            'parentId' => $this->parentId,
            'cover' => $this->cover,
            'status' => $this->status,
            'order' => $this->order,
        ]);

        $query->andFilterWhere(['like', 'parents', $this->parents])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'category', $this->category]);
        $query->andWhere(['status'=>1]);
        return $dataProvider;
    }

    /***
     * 获取文章的顶级分类
     * @return array|
     */
    public static  function getArticleTopCategory()
    {
        $categoryGroups = Yii::$app->cache->get('category_map');
        if(!empty($categoryGroups))
        {
            $articleGroupId = 10;
            $categoryGroups = self::find()->from('category')->
            where(['groupId'=>10 , 'parentId'=>0])->
            select('id , name as text')->asArray()->all();
            Yii::$app->cache->set('category_map' , $categoryGroups , 3600);
        }
        return $categoryGroups;
    }


    /***
     * 获取父章节下面的子章节
     * @param $chapterid
     * @param int $treeid
     * @return bool
     */
    public  static  function  getChildren($parentId)
    {
        $arr = self::find()->select('id , name as text')->
        where( ['parentId'=>$parentId ] )->
        asArray()->all();
        return $arr ;
    }

    /***
     * 获取章节的所有上级（包括自己）章节
     * @param $parentId
     * @return array
     */
    public static  function  getParents($parentId)
    {
        $parentsStr = self::find()->select('parents')->where(['id'=>$parentId])->createCommand()->queryScalar();
        try{
             $parents =  self::find()->select('id , title')->where("id in ({$parentsStr})")->createCommand()->queryAll();
        }catch (Exception $e)
        {
           // echo $e->getMessage();
            return [];
        }
        //var_dump($parents); exit();
        return $parents;
    }

    /**
     *  获取树中某一个节点 ，
     */
    public  static  $parents = [];
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


    /***
     * 缓存章节信息  当需要大量查找操作是使用这个 ，少量查询不适合 会消耗很多内存
     * @return array|mixed
     */
    public  static function   getMap()
    {
        $table = self::tableName();
        $cache = Yii::$app->cache->get( $table.'_map');
        if(empty($cache))
        {
            $cache = [];
            $cache_T = self::find()->select("id , title ")->asArray()->all();
            foreach ($cache_T as $val)
            {
                $cache[$val['id']] = $val['name'];
            }
            Yii::$app->cache->set('category_map' , $cache , 3600);
        }
        return  $cache;
    }

    /***
     * 通过字符串  查询 ，
     * @param $idStr
     * @param array $map  传递一个缓冲 ，加快查询速度 。
     * @return array  字符串数组
     */
    public static  function getTitlesByIdstr($idStr ,&$map=[])
    {
        if(empty($idStr)) return [];
        if( empty($map) )
        {
            $table = self::tableName();
            $sql = "select id , title from {$table} where id in({$idStr}) ";
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache = [];
            foreach ( $result as $row )
            {
                $cache[$row['id']] = $row['title'];
            }
            return  $cache;
        }

        $ids = explode( ',' , $idStr);
        $cache = [];
        foreach($ids as $id)
        {
            $cache[$id] = isset($map[$id]) ? $map[$id] : '未知';
        }
        return  $cache;
    }




    /***
     * 获取根章节的名称
     * @param $id
     */
    public static function  getRootName($id)
    {
        $name =self::find()->select('title')->where(['id'=>$id])->scalar();
        return $name;
    }

    /***
     * 获取所有的根章节
     * @param $id
     */
    public static function  getRoots()
    {
        $roots = self::find()->select('id,title')->where(['lvl'=>1])->asArray()->all();
        $temp =  [];
        foreach ($roots as $root)
        {
            $temp[$root['id']] = $root['title'];
        }
        return $temp;
    }

    /***
     * 缓存所有的章节信息 ,用于大量章节查询频繁数据库访问操作
     * @return array|mixed
     */
    public  static function   getChapterMap()
    {
        $chapters =Yii::$app->cache->get('chapter_map');
        if(empty($chapters))
        {
            $chapters = [];
            $chaptersT = self::find()->select("id , title")->asArray()->all();
            foreach ($chaptersT as $val)
            {
                $chapters[$val['id']] = $val['title'];
            }
            Yii::$app->cache->set('chapter_map' , $chapters , 3600);
        }

        return  $chapters;
    }

    public static  function getChapterList($root)
    {
        $arr = self::find()->select('id,parentId as parentid,title as name,lvl , root,pdfpages')->
        andFilterWhere(['root'=>$root ,'status'=>1])->orderBy('id asc')->
        asArray()->all();
        return $arr;
    }

    /*
     * 根据根章节获取目录树
     * */
    public static  function getTreeMap($root)
    {
        $cacheKey = 'chapter_tree_map_'.$root;
        $treeMap  =  Yii::$app->cache->get( $cacheKey );
        $treeMap =false;  //阻止缓存
        if(!$treeMap)
        {
            $arr = self::find()->select('id,parentId as parentid,title as name,lvl , root')->
            andFilterWhere(['root'=>$root ,'status'=>1])->orderBy('id asc')->
            asArray()->all();
            $treeMap =  \common\utils\TreeUtils::list2tree($arr);
            //var_dump($treeMap); exit();
            Yii::$app->cache->set( $cacheKey , $treeMap );
        }
        return $treeMap;
    }

    /*
 * 根据根章节获取目录树
 * */
    public static  function getBookChapterTree($bookid)
    {
        $cacheKey = 'book_chapter_tree_map_'.$bookid;
        $treeMap  =  Yii::$app->cache->get( $cacheKey );
        $treeMap =false;  //阻止缓存
        if(!$treeMap)
        {
            $arr = self::find()->select('id,parentId as parentid,title as name,lvl , root')->
            andFilterWhere(['bookId'=>$bookid ,'status'=>1])->orderBy('id asc')->
            asArray()->all();
            $treeMap =  \common\utils\TreeUtils::list2tree($arr);
            //var_dump($treeMap); exit();
            Yii::$app->cache->set( $cacheKey , $treeMap );
        }
        return $treeMap;
    }



    /***
     * 获取一个字符串的最后一个id 对应的章节名称
     * @param $chapterStr
     * @return mixed|string
     */
    public  static function   getLastChapterName($chapterStr)
    {
        $ids = explode(',' , $chapterStr);
        $id =array_pop($ids);
        if( !intval($id) )  return '选择章节';
        //echo $id;
        $chapterMap = self::getChapterMap();

        return isset($chapterMap[$id]) ? $chapterMap[$id] : '--';
    }



    /****
     * 获取指定目录下的 id->title 键值对
     * @param $categoryId
     * @return array
     */
    public  static function  getRootChapterMapByCateogry($categoryId)
    {
        $categoryId = intval($categoryId);
        if($categoryId==0)
        {
            $sql = "select id ,title from chapter where lvl=1 limit 1000";
        }else{
            $sql = "select id,title from chapter where category in({$categoryId})  and lvl=1  limit 1000";
        }
        $chapterRoots = Yii::$app->sphinx->createCommand($sql)->queryAll();
        $chapterRootsMap = [];
        foreach ($chapterRoots as $value)
        {
            $chapterRootsMap[$value['id']] = $value['title'];
        }

        return $chapterRootsMap;
    }

}
