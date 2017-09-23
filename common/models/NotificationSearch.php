<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Notification;

/**
 * NotificationSearch represents the model behind the search form about `common\models\Notification`.
 */
class NotificationSearch extends Notification
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'fromId', 'targetId', 'createdTime', 'published', 'sendedTime'], 'integer'],
            [['type', 'title', 'content', 'targetType'], 'safe'],
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
        $query = Notification::find();

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
            'fromId' => $this->fromId,
            'targetId' => $this->targetId,
            'createdTime' => $this->createdTime,
            'published' => $this->published,
            'sendedTime' => $this->sendedTime,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'targetType', $this->targetType]);

        return $dataProvider;
    }

    /***
     *  获取最新的5个通知
     */
    public static function getLast()
    {
        $sql = "select id ,title , createdTime  from  batch_notification order by id desc limit 6 ";
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($rows as  &$row)
        {
           $row['createdTime']  =  date("Y-m-d" , $row['createdTime']);
        }
        return $rows;
    }
}
