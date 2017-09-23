<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Book;
use yii\db\ActiveQuery;
use yii\db\Query;
use yii\sphinx\MatchExpression;

/**
 * BookSearch represents the model behind the search form about `common\models\Book`.
 */
class BookSearch extends Book
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'userId', 'collectNum', 'pv', 'createdTime', 'price', 'sort'], 'integer'],
            [['title', 'cover', 'desc', 'code', 'category', 'status', 'auditStatus', 'deveStatus'], 'safe'],
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
        $query = Book::find();
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
        if(empty($this->status))
            $query->andWhere(['in','status',[self::published,self::unpublished]]);
        else
            $query->andWhere(['in','status',[$this->status]]);

        if(!empty($this->auditStatus))
            $query->andWhere(['in','auditStatus',[$this->auditStatus]]);

        if(!empty($this->deveStatus))
            $query->andWhere(['in','deveStatus',[$this->deveStatus]]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'userId' => $this->userId,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

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
    public  function  searchBySphinx($params ,$page=1 ,$pagesize=12 ,$keyword='',$order='')
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
        if(!$order)  $query->orderBy($order." desc");

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

    /***获取书籍列表 查询 sphinx
     * @param $category
     * @param int $page
     * @param int $pagesize
     * @return array
     */
    public static  function  getPageByCategory($category , $page=1 , $pagesize=12 , $keyword='')
    {
        $page = intval($page)? intval($page) :1 ;
        $pagesize=intval($pagesize) ?intval($pagesize) :12;
        $query = new \yii\sphinx\Query();
        $query->setConnection(Yii::$app->sphinx);
        $query->from('book');

        $query->limit($pagesize)->offset( ($page-1)*$pagesize );

        if( !empty($category) )
         $query->andFilterWhere( ['in' , 'category', $category] );
        if($keyword)
          $query->match($keyword);
        $query->orderBy('createdTime desc');
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

    public static  function  getLast($num = 5)
    {
        //Yii::$app->cache->flush();
        $rows = Yii::$app->cache->get('last_book');
        if(!$rows)
        {
            $rows = static::getPageByCategory(null,1,5)['data'];
            foreach ($rows as &$row)
            {
                $row['desc'] = mb_substr($row['desc'],0,80);
                if(mb_strlen($row['desc'])==80)
                    $row['desc'].="...";
                $row['createdTime'] = date('Y-m-d h:i:s',$row['createdTime']);
            }
            Yii::$app->cache->set('last_book' , $rows,1800);
        }
        //var_dump($rows); exit();
        return $rows;
    }

}
