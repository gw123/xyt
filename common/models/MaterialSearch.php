<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Material;
use common\utils\Log;

/**
 * MaterialSearch represents the model behind the search form about `common\models\Material`.
 */
class MaterialSearch extends Material
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status', 'createdTime', 'updatedTime', 'updateUid', 'up', 'pv', 'file_id'], 'integer'],
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
        $query = Material::find();

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
            'up' => $this->up,
            'pv' => $this->pv,
            'file_id' => $this->file_id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }

    public function searchBySphinx($params)
    {
        $query = new \yii\sphinx\Query();
        $query->setConnection(Yii::$app->sphinx);
        $query->from('material');

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
            'uid' => $this->uid,
            'status' => $this->status,
            'createdTime' => $this->createdTime,
            'updatedTime' => $this->updatedTime,
            'updateUid' => $this->updateUid,
            'up' => $this->up,
            'pv' => $this->pv,
            'file_id' => $this->file_id,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'cover', $this->cover])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc])
            ->andFilterWhere(['like', 'content', $this->content]);

        return $dataProvider;
    }

    /***/
    public static function getListByChapterId($chapterId ,$page =1 ,$pagesize =10,$keyword='')
    {
        $query  =  self::find();
        //$field = "id ,title, desc ,content ,createdTime ,userId as uid ,cover";
        $field = '*';
        $query  =  self::find();
        $sql = $query->select($field)->andWhere(['in', 'chapter', [intval($chapterId),0]])->createCommand()->getRawSql();
        $query->limit(20);
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();
        //var_dump($list);exit();
        foreach ( $list as &$item)
        {
            $item['createdTime'] = date('Y-m-d',$item['createdtime']);
        }
        return $list;
    }

    // 获取指定章节的pdf 文件 和对应的页码
    public  static  function  getChapterPdfImage($chapterId)
    {
        $rootChapter = self::find()->select('root')->from('chapter')->where(['id'=>$chapterId])->createCommand()->queryScalar();
        //定位书籍
        $pages = self::find()->select('pdfpages')->from('chapter')->where(['id'=>$chapterId])->createCommand()->queryScalar();
        $result = $result = ['type'=>'img','rootChapter'=>$rootChapter ,'pages' =>$pages];
        return $result;
    }

    // 获取指定章节的pdf 文件 和对应的页码
    public  static  function  getChapterPdf($chapterId)
    {
        $rootChapter = self::find()->select('root')->from('chapter')->where(['id'=>$chapterId])->createCommand()->queryScalar();
        //定位书籍
        $pdfFile = self::find()->select('content')->where(['chapter'=>$rootChapter ,'type'=>2])->createCommand()->queryScalar();
        //Log::info("Pdf".$pdfFile);
        if(empty($pdfFile))
        {
           // Log::error( '书籍未找到!Chapter : '.$chapterId );
            return false;
        }
        $pages = self::find()->select('pdfpages')->from('chapter')->where(['id'=>$chapterId])->createCommand()->queryScalar();

        $result = ['type'=>'pdf','pdfurl'=>$pdfFile ,'pages' =>$pages];
        //Yii::$app->
        return $result;
    }

    public function  getMaterialList($param)
    {
        isset($param['pagesize'] ) ? $pagesize = intval($param['pagesize']):$pagesize=10;
        isset($param['page']) ? $page = intval($param['page']):$page=1;

        if(isset($param['node_id']))  $condition['node_id']=$param['node_id'];
        $condition['status'] = 1;

        $data= $this->find()->where($condition)->limit($pagesize)->offset( ($page-1)*$pagesize )->asArray()->all();
        $total = $this->find()->where($condition)->count();
        $param['currentPage']= $page;
        $param['total']    = $total;
        $param['pagesize'] =$pagesize;
        return ['data'=>$data , 'param'=>$param];
    }

    public static function getPageByCategory($category ,$page ,$pagesize,$keyword){
        $page = intval($page)? intval($page) :1 ;
        $pagesize=intval($pagesize) ?intval($pagesize) :12;
        $query = new \yii\sphinx\Query();
        $query->setConnection(Yii::$app->sphinx);
        $query->from('material');

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
        $rows = Yii::$app->cache->get('last_material',600);
        if(1)
        {
            $query = self::find();
            $condition = [];
            $query->select('material.id,material.title,uid as userId ,nickname,material.createdTime,desc,cover');
            $query->innerJoin('user','user.id=material.uid');
            $query->orderBy('createdTime desc');
            $rows =  $query->where($condition)->limit($num)->asArray()->all();
            foreach ($rows as &$row)
            {
                $row['desc'] = mb_substr($row['desc'],0,80);
                if(mb_strlen($row['desc'])==80)
                    $row['desc'].="...";
                $row['createdTime'] = date('Y-m-d h:i:s',$row['createdTime']);
            }
            Yii::$app->cache->set('last_material' , $rows);
        }
        return $rows;
    }
}
