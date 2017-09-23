<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Course;

/**
 * CourseSearch represents the model behind the search form about `common\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'buyable', 'buyExpiryTime', 'maxStudentNum', 'expiryDay', 'lessonNum', 'giveCredit', 'rating', 'ratingNum', 'vipLevelId', 'categoryId', 'recommended', 'recommendedSeq', 'recommendedTime', 'locationId', 'parentId', 'studentNum', 'hitNum', 'noteNum', 'userId', 'discountId', 'daysOfNotifyBeforeDeadline', 'watchLimit', 'singleBuy', 'createdTime', 'updatedTime', 'freeStartTime', 'freeEndTime', 'approval', 'locked', 'maxRate', 'tryLookable', 'tryLookTime', 'orgId'], 'integer'],
            [['title', 'subtitle', 'status', 'type', 'expiryMode', 'showStudentNumType', 'serializeMode', 'tags', 'smallPicture', 'middlePicture', 'largePicture', 'about', 'teacherIds', 'goals', 'audiences', 'address', 'deadlineNotify', 'useInClassroom', 'conversationId', 'orgCode', 'category', 'chapter', 'point'], 'safe'],
            [['price', 'originPrice', 'coinPrice', 'originCoinPrice', 'income', 'discount'], 'number'],
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
        $query = Course::find();

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
            'buyable' => $this->buyable,
            'buyExpiryTime' => $this->buyExpiryTime,
            'maxStudentNum' => $this->maxStudentNum,
            'price' => $this->price,
            'originPrice' => $this->originPrice,
            'coinPrice' => $this->coinPrice,
            'originCoinPrice' => $this->originCoinPrice,
            'expiryDay' => $this->expiryDay,
            'income' => $this->income,
            'lessonNum' => $this->lessonNum,
            'giveCredit' => $this->giveCredit,
            'rating' => $this->rating,
            'ratingNum' => $this->ratingNum,
            'vipLevelId' => $this->vipLevelId,
            'categoryId' => $this->categoryId,
            'recommended' => $this->recommended,
            'recommendedSeq' => $this->recommendedSeq,
            'recommendedTime' => $this->recommendedTime,
            'locationId' => $this->locationId,
            'parentId' => $this->parentId,
            'studentNum' => $this->studentNum,
            'hitNum' => $this->hitNum,
            'noteNum' => $this->noteNum,
            'userId' => $this->userId,
            'discountId' => $this->discountId,
            'discount' => $this->discount,
            'daysOfNotifyBeforeDeadline' => $this->daysOfNotifyBeforeDeadline,
            'watchLimit' => $this->watchLimit,
            'singleBuy' => $this->singleBuy,
            'createdTime' => $this->createdTime,
            'updatedTime' => $this->updatedTime,
            'freeStartTime' => $this->freeStartTime,
            'freeEndTime' => $this->freeEndTime,
            'approval' => $this->approval,
            'locked' => $this->locked,
            'maxRate' => $this->maxRate,
            'tryLookable' => $this->tryLookable,
            'tryLookTime' => $this->tryLookTime,
            'orgId' => $this->orgId,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'subtitle', $this->subtitle])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'expiryMode', $this->expiryMode])
            ->andFilterWhere(['like', 'showStudentNumType', $this->showStudentNumType])
            ->andFilterWhere(['like', 'serializeMode', $this->serializeMode])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'smallPicture', $this->smallPicture])
            ->andFilterWhere(['like', 'middlePicture', $this->middlePicture])
            ->andFilterWhere(['like', 'largePicture', $this->largePicture])
            ->andFilterWhere(['like', 'about', $this->about])
            ->andFilterWhere(['like', 'teacherIds', $this->teacherIds])
            ->andFilterWhere(['like', 'goals', $this->goals])
            ->andFilterWhere(['like', 'audiences', $this->audiences])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'deadlineNotify', $this->deadlineNotify])
            ->andFilterWhere(['like', 'useInClassroom', $this->useInClassroom])
            ->andFilterWhere(['like', 'conversationId', $this->conversationId])
            ->andFilterWhere(['like', 'orgCode', $this->orgCode])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'point', $this->point]);

        return $dataProvider;
    }

    /***
     * 获取到 以id为key title 为值的数组
     * @return array|Course[]|Exam[]
     */
    public static function  getMap()
    {
        $query= self::find();
        $result  = Yii::$app->cache->get('course_map');
        if(empty($result))
        {
            $result_ =$query->select("id ,title")->asArray()->all();
            $result = [];
            foreach ($result_ as $row)
            {
                $result[$row['id']] = $row['title'];
            }
            unset($result_);
            Yii::$app->cache->set('course_map', $result,3600);
        }
        return $result;
    }
}
