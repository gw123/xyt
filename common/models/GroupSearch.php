<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Group;

/**
 * GroupSearch represents the model behind the search form about `common\models\Group`.
 */
class GroupSearch extends Group
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'memberNum', 'threadNum', 'postNum', 'ownerId', 'createdTime'], 'integer'],
            [['title', 'about', 'logo', 'backgroundLogo', 'status', 'tag', 'chapter', 'point'], 'safe'],
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
        $query = Group::find();

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
            'memberNum' => $this->memberNum,
            'threadNum' => $this->threadNum,
            'postNum' => $this->postNum,
            'ownerId' => $this->ownerId,
            'createdTime' => $this->createdTime,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'logo', $this->logo])
            ->andFilterWhere(['like', 'backgroundLogo', $this->backgroundLogo])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'point', $this->point]);

        return $dataProvider;
    }
}
