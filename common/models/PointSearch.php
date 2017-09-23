<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Point;

/**
 * PointSearch represents the model behind the search form about `common\models\Point`.
 */
class PointSearch extends Point
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'uid', 'status', 'createdTime', 'cover'], 'integer'],
            [['category', 'chapter', 'title', 'desc'], 'safe'],
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
        $query = Point::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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
            'cover' => $this->cover,
        ]);

        $query->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'desc', $this->desc]);

        return $dataProvider;
    }

    /***
     * 获取指定章节下的知识点
     * @param $chapterId
     * @return array|Point[]
     */
    public  static function  getListByChapterId($chapterId)
    {
        $query  =  self::find();
        $field = "id, desc ,uid ,category,chapter ,title,createdTime";
        $sql = $query->select($field)->andWhere(['in', 'chapter', [intval($chapterId),0]])->createCommand()->getRawSql();
        $query->limit(50);
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();
        //return $query->andFilterWhere(['like', 'chapter', $chapterId])->asArray()->all();
        return $list;
    }
}
