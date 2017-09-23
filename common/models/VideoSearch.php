<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Video;

/**
 * VideoSearch represents the model behind the search form about `common\models\Video`.
 */
class VideoSearch extends Video
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status', 'createdTime', 'updatedTime', 'updateUid'], 'integer'],
            [['category', 'chapter', 'cover', 'title', 'desc', 'content'], 'safe'],
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
        $query = Video::find();

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
        $query->andWhere(['in','status',[self::published,self::unpublished]]);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'uid' => $this->uid,
            'status' => $this->status,
            'createdTime' => $this->createdTime,
            'updatedTime' => $this->updatedTime,
            'updateUid' => $this->updateUid,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }

    public static function getListByChapterId($chapterId)
    {
        $query  =  self::find();
        //$field = "id,title,userId ,category,chapter,createdTime,content";
        $field = "*";
        $sql = $query->select($field)->andWhere(['in', 'chapter', [intval($chapterId),0]])->createCommand()->getRawSql();
        $query->limit(50);
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();
        //return $query->andFilterWhere(['like', 'chapter', $chapterId])->asArray()->all();
        return $list;
    }

    public static function getPageByCategory($category ,$page ,$pagesize,$keyword=''){
        $page = intval($page)? intval($page) :1 ;
        $pagesize=intval($pagesize) ?intval($pagesize) :12;
        $query = new \yii\sphinx\Query();
        $query->setConnection(Yii::$app->sphinx);
        $query->from('video');

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
        $rows = Yii::$app->cache->get('last_video',600);
        if(1)
        {
            $query = self::find();
            $condition = [];
            $query->select('video.id,video.title,uid as userId ,nickname,video.createdTime,desc,cover');
            $query->innerJoin('user','user.id=video.uid');
            $query->orderBy('createdTime desc');
            $rows =  $query->where($condition)->limit($num)->asArray()->all();
            foreach ($rows as &$row)
            {
                $row['desc'] = mb_substr($row['desc'],0,80);
                if(mb_strlen($row['desc'])==80)
                    $row['desc'].="...";
                $row['createdTime'] = date('Y-m-d h:i:s',$row['createdTime']);
            }
            Yii::$app->cache->set('last_video' , $rows);
        }
        return $rows;
    }
}
