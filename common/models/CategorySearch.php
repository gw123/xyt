<?php

namespace common\models;

use common\utils\TreeUtils;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Category;

/**
 * CategorySearch represents the model behind the search form about `common\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'weight', 'groupId', 'parentId', 'orgId'], 'integer'],
            [['code', 'name', 'icon', 'path', 'description', 'orgCode'], 'safe'],
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
        $query = Category::find();

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
            'weight' => $this->weight,
            'groupId' => $this->groupId,
            'parentId' => $this->parentId,
            'orgId' => $this->orgId,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'orgCode', $this->orgCode]);

        return $dataProvider;
    }

     /***
      * 获取根章节的名称
     * @param $id
     */
     public static function  getRootName($id)
     {
        $name =self::find()->select('name')->from('category_group')->where(['id'=>$id])->scalar();
         return $name;
     }

    /***
     * 获取一级 书籍目录
     * @return array
     */
     public static  function  getBooklvl1Category()
     {
         $sql = "SELECT id ,`name` FROM  category  WHERE groupId=10 AND parentId=0";
         $res =Yii::$app->db->createCommand($sql)->queryAll();
         return $res;
     }

    /***
     * 获取一级 书籍目录
     * @return array
     */
    public static  function  getBooklvl2CategoryId2NameMap()
    {
        $sql = "SELECT id ,`name`  FROM  category  WHERE groupId=10 AND parentId!=0";
        $res =Yii::$app->db->createCommand($sql)->queryAll();
        $temp = [];
        foreach ($res as $value)
        {
            $temp[$value['id']]  =$value['name'];
        }
        return $temp;
    }

    /***
     *  获取到书籍的分类
     */
    public  static function getCategoryTreeByGourp($group=10)
    {
        if($group!=1&&$group!=10)
            return [];
        $sql = "SELECT id  ,`name` as title ,parentId as parentid FROM  category  WHERE groupId=".$group;
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        $tree = TreeUtils::list2tree($rows);
        //var_dump($tree); exit();
        if($group==1)
            $tree = $tree[0]['children'];
        return $tree;
    }

    /***
     *  获取到书籍的分类
     */
    public  static function getBookCategoryTree($group=10)
    {
        if($group!=1&&$group!=10)
            return [];
        $key = 'CategoryTree_'.$group;
        $tree = Yii::$app->cache->get($key);
        if(empty($tree))
        {
            $sql = "SELECT id  ,`name` as title ,parentId as parentid FROM  category  WHERE groupId=10 ";
            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            $tree = TreeUtils::list2tree($rows);
            Yii::$app->cache->set($key,$tree,3600*24);
        }
        return $tree;
    }
    /***
     *  获取二级章节 和 章节下面的数据
     */
     public static  function  getLvl2CategoryAndBooks()
     {
         $sql = "SELECT id  ,`name`  FROM  category  WHERE groupId=10 AND parentId=0";
         $rows = Yii::$app->db->createCommand($sql)->queryAll();
         $categorylvl1Map =[] ;
         $categorylvl1List = [];
         foreach ($rows as $value)
         {
             $categorylvl1Map[$value['id']]  = $value['name'];
             $categorylvl1List[$value['id']]['title'] = $value['name'];
         }

         $sql = "SELECT id ,parentId ,`name`  FROM  category  WHERE groupId=10 AND parentId!=0";
         $rows = Yii::$app->db->createCommand($sql)->queryAll();
         $categorylvl2Map =[] ;
         $categorylvl2ParentMap=[];
         foreach ($rows as $value)
         {
             $categorylvl2Map[$value['id']]  =$value['name'];
             $categorylvl2ParentMap[$value['id']] = $value['parentId'];
         }

         $sql = "select id ,title ,category from chapter where  lvl=1  limit 200";
         $books = Yii::$app->db->createCommand($sql)->queryAll();
         $lvl2Categorys = [];
         foreach ($books as $book)
         {
              $categoryStr = $book['category'];
              $categorys= explode(',' ,$categoryStr);
              foreach ($categorys as  $categoryId)
              {
                  if(isset($categorylvl2Map[$categoryId]))
                  {
                      $lvl2Categorys[$categoryId]['id'] = $categoryId;
                      $lvl2Categorys[$categoryId]['children'][] = $book;

                  }
              }
         }

         foreach ( $lvl2Categorys as $key=>$category)
         {
             $category['title'] = $categorylvl2Map[$key];
             $parentId = $categorylvl2ParentMap[$key];
             $categorylvl1List[$parentId]['id'] = $parentId;
             $categorylvl1List[$parentId]['children'][] =  $category;
         }
        return $categorylvl1List;
     }

    /***
     * 获取所有的根章节
     * @param $id
     */
    public static function  getRootCategorys()
    {
        return self::find()->select('id,name')->from('category_group')->asArray()->all();
    }

    /***
     *  获取顶层课程章节
     * @return array|
     */
    public static  function getLvl1CourseCategory()
    {
        $categorys = Yii::$app->cache->get('lvl1CourseCategory_map');
        if(!$categorys)
        {
            $categorys = self::find()->select('id , name as text')->where( ['parentId'=>0 ,'groupId'=>10] )->asArray()->all();
            Yii::$app->cache->set('lvl1CourseCategory_map' , $categorys , 7200);
        }
        return $categorys ;
    }

    /***
     * 获取父章节下面的子章节
     * @param $chapterid
     * @param int $treeid
     * @return bool
     */
    public  static  function  getCategorysByParent($parentid)
    {
        $arr = self::find()->select('id , name as text')->
        where( ['parentId'=>$parentid ] )->
        asArray()->all();
        return $arr ;
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
            $cache_T = self::find()->select("id , name ")->asArray()->all();
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
     * @return array  字符串数组  [ id=>title ,  id=>title ]
     */
    public static  function getTitlesByIdstr($idStr ,&$map=[])
    {
        if(empty($idStr)) return [];
        if( empty($map) )
        {
            $table = self::tableName();
            $sql = "select id , name from {$table} where id in({$idStr}) ";
            $result = Yii::$app->db->createCommand($sql)->queryAll();
            $cache = [];
            foreach ( $result as $row )
            {
                $cache[$row['id']] = $row['name'];
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
     * 获取一个字符串的最后一个id 对应的章节名称
     * @param $categoryStr
     * @return mixed|string
     */
    public  static function   getLastCategoryName($categoryStr)
    {
        $ids = explode(',' , $categoryStr);
        $id =array_pop($ids);
        if( !intval($id) )  return '选择目录';
        //echo $id;
        $categoryMap = self::getMap();
        //var_dump($categoryMap); exit();
        return isset($categoryMap[$id]) ? $categoryMap[$id] : '--';
    }

    /*
    *    获取目录树
    * */
    public static  function getTreeMap($root)
    {

        $cacheKey = 'category_tree_map_'.$root;
        $treeMap  =  Yii::$app->cache->get( $cacheKey );
        $treeMap =false;  //阻止缓存
        if(!$treeMap)
        {
            $arr = self::find()->select('id,parentId as parentid,name ,groupId as root')->
            andFilterWhere(['groupId'=>$root])->
            asArray()->all();
            //var_dump($arr); exit();
            $treeMap =  \common\utils\TreeUtils::list2tree($arr);

            Yii::$app->cache->set( $cacheKey , $treeMap );
        }

        return $treeMap;
    }
}
