<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Question;

/**
 * QuestionSearch represents the model behind the search form about `common\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'categoryId', 'parentId', 'subCount', 'finishedTimes', 'passedTimes', 'userId', 'updatedTime', 'createdTime', 'copyId'], 'integer'],
            [['type', 'stem', 'answer', 'analysis', 'metas', 'difficulty', 'target', 'category', 'chapter', 'point'], 'safe'],
            [['score'], 'number'],
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
        $query = Question::find();

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
            'score' => $this->score,
            'categoryId' => $this->categoryId,
            'parentId' => $this->parentId,
            'subCount' => $this->subCount,
            'finishedTimes' => $this->finishedTimes,
            'passedTimes' => $this->passedTimes,
            'userId' => $this->userId,
            'updatedTime' => $this->updatedTime,
            'createdTime' => $this->createdTime,
            'copyId' => $this->copyId,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'stem', $this->stem])
            ->andFilterWhere(['like', 'answer', $this->answer])
            ->andFilterWhere(['like', 'analysis', $this->analysis])
            ->andFilterWhere(['like', 'metas', $this->metas])
            ->andFilterWhere(['like', 'difficulty', $this->difficulty])
            ->andFilterWhere(['like', 'target', $this->target])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'point', $this->point]);

        return $dataProvider;
    }
}
