<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CourseLesson;

/**
 * CourseLessonSearch represents the model behind the search form about `common\models\CourseLesson`.
 */
class CourseLessonSearch extends CourseLesson
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'courseId', 'chapterId', 'number', 'seq', 'free', 'giveCredit', 'requireCredit', 'mediaId', 'homeworkId', 'exerciseId', 'length', 'materialNum', 'quizNum', 'learnedNum', 'viewedNum', 'startTime', 'endTime', 'memberNum', 'maxOnlineNum', 'liveProvider', 'userId', 'createdTime', 'updatedTime', 'copyId', 'testStartTime'], 'integer'],
            [['status', 'title', 'summary', 'tags', 'type', 'content', 'mediaSource', 'mediaName', 'mediaUri', 'replayStatus', 'testMode', 'category', 'chapter', 'point'], 'safe'],
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
        $query = CourseLesson::find();

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
            'courseId' => $this->courseId,
            'chapterId' => $this->chapterId,
            'number' => $this->number,
            'seq' => $this->seq,
            'free' => $this->free,
            'giveCredit' => $this->giveCredit,
            'requireCredit' => $this->requireCredit,
            'mediaId' => $this->mediaId,
            'homeworkId' => $this->homeworkId,
            'exerciseId' => $this->exerciseId,
            'length' => $this->length,
            'materialNum' => $this->materialNum,
            'quizNum' => $this->quizNum,
            'learnedNum' => $this->learnedNum,
            'viewedNum' => $this->viewedNum,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'memberNum' => $this->memberNum,
            'maxOnlineNum' => $this->maxOnlineNum,
            'liveProvider' => $this->liveProvider,
            'userId' => $this->userId,
            'createdTime' => $this->createdTime,
            'updatedTime' => $this->updatedTime,
            'copyId' => $this->copyId,
            'testStartTime' => $this->testStartTime,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'mediaSource', $this->mediaSource])
            ->andFilterWhere(['like', 'mediaName', $this->mediaName])
            ->andFilterWhere(['like', 'mediaUri', $this->mediaUri])
            ->andFilterWhere(['like', 'replayStatus', $this->replayStatus])
            ->andFilterWhere(['like', 'testMode', $this->testMode])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'chapter', $this->chapter])
            ->andFilterWhere(['like', 'point', $this->point]);
        $query->orderBy('courseId asc, seq asc');
        return $dataProvider;
    }

    /***
     * @param $chapterId
     */
    public static  function  getTestPaperListByChapter($chapterId)
    {
        if(empty($chapterId)) return [];
        $query  =  self::find();
        $field = " lessonId , title , tId ,courseId , courseTitle, createdtime";
        $query  =  self::find()->from('testpaper');
        $sql = $query->select($field)->andWhere(['in', 'chapter', [intval($chapterId),0]])->createCommand()->getRawSql();
        $query->limit(50);
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();

        foreach ( $list as &$item)
        {
            $item['createdTime'] = date('Y-m-d',$item['createdtime']);
            $item['courseTitle'] = $item['coursetitle'];
            $item['courseId'] = $item['courseid'];
            $item['lessonId'] = $item['lessonid'];
            $item['tId'] = $item['tid'];
        }

        return $list;
    }
}
