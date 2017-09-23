<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\File;

/**
 * FileSearch represents the model behind the search form about `common\models\File`.
 */
class FileSearch extends File
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'groupId', 'userId', 'size', 'status', 'createdTime', 'uploadFileId'], 'integer'],
            [['uri', 'mime', 'chapter', 'path', 'cotegory'], 'safe'],
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
        $query = File::find();

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
            'groupId' => $this->groupId,
            'userId' => $this->userId,
            'size' => $this->size,
            'status' => $this->status,
            'createdTime' => $this->createdTime,
            'uploadFileId' => $this->uploadFileId,
        ]);

        $query->andFilterWhere(['like', 'uri', $this->uri])
            ->andFilterWhere(['like', 'mime', $this->mime])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'path', $this->path])
            ->andFilterWhere(['like', 'cotegory', $this->cotegory]);
        $query->orderBy('id desc');
        return $dataProvider;
    }


}
