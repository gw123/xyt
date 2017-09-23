<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Caiji;

/**
 * CaijiSearch represents the model behind the search form about `frontend\models\Caiji`.
 */
class CaijiSearch extends Caiji
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['source_id', 'tag', 'title', 'content', 'attach', 'url', 'createdTime','contentType'], 'safe'],
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
        $query = Caiji::find();

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
        $query->select('id, source_id,tag,attach ,contentType status,createdTime,title,url');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'createdTime' => $this->createdTime,
            'contentType'=>$this->contentType
        ]);
        $query->orderBy('id desc ');

        $query->andFilterWhere(['like', 'source_id', $this->source_id])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'attach', $this->attach])
            ->andFilterWhere(['like', 'url', $this->url]);

        return $dataProvider;
    }
}
