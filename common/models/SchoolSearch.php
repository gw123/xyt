<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\School;

/**
 * SchoolSearch represents the model behind the search form about `common\models\School`.
 */
class SchoolSearch extends School
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'schoolid', 'clicks', 'monthclicks', 'weekclicks', 'f985', 'f211', 'autonomyrs', 'library', 'schoolnature', 'ranking', 'rankingCollegetype', 'ads', 'center', 'master', 'num'], 'integer'],
            [['schoolcode', 'schoolname', 'province', 'schooltype', 'schoolproperty', 'edudirectly', 'level', 'membership', 'shoufei', 'jianjie', 'guanwang', 'oldname'], 'safe'],
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
        $query = School::find();

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
            'schoolid' => $this->schoolid,
            'clicks' => $this->clicks,
            'monthclicks' => $this->monthclicks,
            'weekclicks' => $this->weekclicks,
            'f985' => $this->f985,
            'f211' => $this->f211,
            'autonomyrs' => $this->autonomyrs,
            'library' => $this->library,
            'schoolnature' => $this->schoolnature,
            'ranking' => $this->ranking,
            'rankingCollegetype' => $this->rankingCollegetype,
            'ads' => $this->ads,
            'center' => $this->center,
            'master' => $this->master,
            'num' => $this->num,
        ]);

        $query->andFilterWhere(['like', 'schoolcode', $this->schoolcode])
            ->andFilterWhere(['like', 'schoolname', $this->schoolname])
            ->andFilterWhere(['like', 'province', $this->province])
            ->andFilterWhere(['like', 'schooltype', $this->schooltype])
            ->andFilterWhere(['like', 'schoolproperty', $this->schoolproperty])
            ->andFilterWhere(['like', 'edudirectly', $this->edudirectly])
            ->andFilterWhere(['like', 'level', $this->level])
            ->andFilterWhere(['like', 'membership', $this->membership])
            ->andFilterWhere(['like', 'shoufei', $this->shoufei])
            ->andFilterWhere(['like', 'jianjie', $this->jianjie])
            ->andFilterWhere(['like', 'guanwang', $this->guanwang])
            ->andFilterWhere(['like', 'oldname', $this->oldname]);

        return $dataProvider;
    }
}
