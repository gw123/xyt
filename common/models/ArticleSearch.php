<?php

namespace common\models;

use common\utils\TreeUtils;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;
use yii\db\ActiveRecord;

/**
 * ArticleSearch represents the model behind the search form about `common\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoryId', 'publishedTime', 'pv', 'featured', 'promoted', 'sticky',
                'postNum', 'upsNum', 'userId', 'createdTime', 'updatedTime'], 'integer'],
            [['title', 'tagIds', 'source', 'sourceUrl',
                'picture', 'status', 'category', 'chapter'], 'safe',],
        ];
    }



    /**
     * 设置要验证的字段
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        $scenarios = Model::scenarios();
        $scenarios['search'] = ['id','source','status' ,'promoted','createdTime','publishedTime','userId','category','chapter','point'];

        return $scenarios;
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
        $query = Article::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        $query->andWhere(['in','status',[self::published,self::unpublished]]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'categoryId' => $this->categoryId,
            'publishedTime' => $this->publishedTime,
            'userId' => $this->userId,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'tagIds', $this->tagIds])
            ->andFilterWhere(['like', 'source', $this->source])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'orgCode', $this->orgCode])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter]);

        $query->orderBy('id desc');

        return $dataProvider;
    }

    /***
     * @param $params         查找参数
     * @param int $page
     * @param int $pagesize
     * @param string $keyword  全文检索关键词
     * @param string $order     排序字段
     * @return array
     */
    public static function  searchBySphinx($params ,$page=1 ,$pagesize=12 ,$keyword='',$order='')
    {
        $page = intval($page)? intval($page) :1 ;
        $pagesize=intval($pagesize) ?intval($pagesize) :12;
        $query = new \yii\sphinx\Query();
        $query->setConnection(Yii::$app->sphinx);
        $query->from( self::tableName() );
        $query->limit($pagesize)->offset( ($page-1)*$pagesize );

        if( isset($params['category'])&&$params['category'] )
            $query->andFilterWhere( ['in' , 'category', $params['category']] );

        if($keyword)  $query->match($keyword);
        if($order)  $query->orderBy($order." desc");

        $total = $query->count();
        //$sql =  $query->createCommand(  )->getRawSql();echo $sql;
        $rows =  $query->createCommand(  )->queryAll();
        foreach ($rows as &$row)
        {
            $row['createdTime'] = $row['createdtime'];
            $row['userId'] = $row['userid'];
        }
        return  [ 'data'=>$rows ,'total'=>$total ] ;
    }

    /***
     * 热门
     * @return array|Article[]
     */
    public static  function getHot()
    {
        Yii::$app->cache->flush();
        $result = Yii::$app->cache->get('hot_aritcle',600);
        if(!$result)
        {
            $result = static::searchBySphinx(null,1,10,'','pv')['data'];
            Yii::$app->cache->set('hot_article' , $result);
        }
        return $result;
    }
    /***
     * 最新
     * @return array|Article[]
     */
    public static function  getLast($num=20)
    {
        //Yii::$app->cache->flush();
        $rows = Yii::$app->cache->get('last_aritcle',600);
        if(!$rows)
        {
            $rows = static::searchBySphinx(null,1,20,'','createdTime')['data'];
            Yii::$app->cache->set('last_aritcle' , $rows);
        }
        return $rows;
    }
    /***
     * 推荐
     * @return array|Article[]
     */
    public static function  getRecommend()
    {Yii::$app->cache->flush();
        $result = Yii::$app->cache->get('recomment_aritcle',600);
        if(!$result)
        {
            $result = static::searchBySphinx(null,1,10,'','promoted')['data'];
            foreach ($result as &$item)
            {
                $item['date'] = date('Y:m:d' ,$item['createdTime']);
                $item['desc'] = $item['desc'] ? $item['desc'] : '点击查看详情';
                $item['cover'] = Yii::$app->params['defaultArticleImage'];
                $item['categoryName'] = CategorySearch::getLastCategoryName($item['category']);
                $item['categoryName'] ="<a href='/index/book?category={$item['category']}'>".$item['categoryName']."</a>";
                $chapters = ChapterSearch::getTitlesByIdstr($item['chapter']);
                $tagStr = '';
                foreach ($chapters as $index => $chapterTitle)
                {
                    $chapterTitle = mb_substr($chapterTitle , 0 , 16);
                    $tagStr .="<a href='/index/book-detail?id={$index}' target='_blank' class='tag'>{$chapterTitle} </a>";
                }
                $item['chapterNameTags'] = $tagStr;
            }
        }
        Yii::$app->cache->set('recomment_aritcle' , $result);
        return $result;
    }

    public static  function  getArticleListByChapterId($chapterId)
    {
        $query  =  self::find();
        $field = "id,title ,category,chapter,createdTime";
        $query->limit(50);
        $sql = $query->select($field)->andWhere(['in', 'chapter', [intval($chapterId),0]])->createCommand()->getRawSql();
        //echo $sql;  exit();
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();
        //var_dump($list);  exit();
        //return $query->andFilterWhere(['like', 'chapter', $chapterId])->asArray()->all();
        foreach ( $list as &$item)
        {
            $item['createdTime'] = date('Y-m-d', $item['createdtime']);
        }
        return $list;
    }

    /***
     * 选择和该文章类似相近的文章
     * @param $id
     * @return array
     */
    public  static function  getlike($id)
    {
        if(empty($id)) return  [];
        $articleChapter =  Article::find()->select('chapter')->where(['id'=>$id])->createCommand()->queryScalar();
        if(empty($articleChapter)) return [];
        $sql = "select id ,title from  article where  chapter in({$articleChapter}) limit 10";
        $data = Yii::$app->sphinx->createCommand($sql)->queryAll();
        return $data;
    }

    /***
     *  获取 文章顶级目录 以及 目录下面的文章
     */
    public  static  function  getPageByCategory($category , $page=1 , $pagesize=12, $keyword='')
    {
        $argv_ ='article_'.md5( serialize( func_get_args() ) );
        $ret = Yii::$app->cache->get($argv_);
        if(!$ret)
        {
            $page = intval($page)? intval($page) :1 ;
            $pagesize=intval($pagesize) ?intval($pagesize) :12;
            $query = new \yii\sphinx\Query();
            $query->setConnection(Yii::$app->sphinx);
            $query->from('article');

            $query->limit($pagesize)->offset( ($page-1)*$pagesize );

            if( !empty($category) )
                $query->andFilterWhere( ['in' , 'category', $category] );
            if($keyword)
                $query->match($keyword);
            $query->orderBy('createdTime desc');
            $total = $query->count();
            //$sql =  $query->createCommand(  )->getRawSql();echo $sql;
            $articles =  $query->createCommand(  )->queryAll();
            //echo $sql ; var_dump($articles);exit;
            foreach ($articles as &$article)
            {
                $article['userId'] = $article['userid'];
                $article['createdTime'] = date('Y:m:d' ,$article['createdtime']);
                $article['desc'] = $article['desc'] ? $article['desc'] : '点击查看详情';
                $article['cover'] = Yii::$app->params['defaultArticleImage'];
                $article['categoryName'] = CategorySearch::getLastCategoryName($article['category']);
                $chapters = ChapterSearch::getTitlesByIdstr($article['chapter']);
                $tagStr = '';
                foreach ($chapters as $index => $chapterTitle)
                {
                    $chapterTitle = mb_substr($chapterTitle , 0 , 6);
                    $tagStr .="<a href='/index/detal?id={$index}' target='_blank' class='tag'>{$chapterTitle} </a>";
                }
                //echo $tagStr;
                $article['chapterNameTags'] = $tagStr;
            }
            $ret = [ 'data'=>$articles ,'total'=>$total ] ;
            Yii::$app->cache->set($argv_,$ret,600);
        }


        return  $ret;
    }

    /***
     *  获取 文章顶级目录 以及 目录下面的文章
     */
    public  static  function  getArticlesByCategory()
    {
        $sql = "select id ,name  as title from category where groupId=10 and parentId=0 ";
        $list_ = Yii::$app->db->createCommand($sql)->queryAll();
        $list = [];
        foreach ($list_ as &$item)
        {
            //获取对应的文章
            $sql = "select id , category ,chapter ,title ,desc ,userId as uid ,picture as cover ,createdtime as date from article where category in({$item['id']}) limit 20 ";
            $articles = Yii::$app->sphinx->createCommand($sql)->queryAll();

            foreach ($articles as &$article)
            {
                $article['date'] = date('Y:m:d' ,$article['date']);
                $article['desc'] = $article['desc'] ? $article['desc'] : '点击查看详情';
                $article['cover'] = Yii::$app->params['defaultArticleImage'];
                $article['categoryName'] = CategorySearch::getLastCategoryName($article['category']);
                $chapters = ChapterSearch::getTitlesByIdstr($article['chapter']);
                $tagStr = '';
                foreach ($chapters as $index => $chapterTitle)
                {
                    $chapterTitle = mb_substr($chapterTitle , 0 , 6);
                    $tagStr .="<a href='/index/book-detal?id={$index}' target='_blank' class='tag'>{$chapterTitle} </a>";
                }
                //echo $tagStr;
                $article['chapterNameTags'] = $tagStr;
            }

            $item['articles'] = $articles;
            $list[$item['id']] = $item;
        }
        //var_dump($list); exit();
        return $list;
    }

    public  static function  test(){
        //$recode = new ActiveRecord();
        //$recode::findBySql()
    }
}
