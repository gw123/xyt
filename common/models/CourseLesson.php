<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "course_lesson".
 *
 * @property string $id
 * @property string $courseId
 * @property string $chapterId
 * @property string $number
 * @property string $seq
 * @property integer $free
 * @property string $status
 * @property string $title
 * @property string $summary
 * @property string $tags
 * @property string $type
 * @property string $content
 * @property string $giveCredit
 * @property string $requireCredit
 * @property string $mediaId
 * @property string $mediaSource
 * @property string $mediaName
 * @property string $mediaUri
 * @property string $homeworkId
 * @property string $exerciseId
 * @property string $length
 * @property string $materialNum
 * @property string $quizNum
 * @property string $learnedNum
 * @property string $viewedNum
 * @property string $startTime
 * @property string $endTime
 * @property string $memberNum
 * @property string $replayStatus
 * @property integer $maxOnlineNum
 * @property string $liveProvider
 * @property string $userId
 * @property string $createdTime
 * @property string $updatedTime
 * @property integer $copyId
 * @property string $testMode
 * @property integer $testStartTime
 * @property string $category
 * @property string $chapter
 * @property string $point
 */
class CourseLesson extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'course_lesson';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseId', 'number', 'seq', 'title', 'userId', 'createdTime'], 'required'],
            [['courseId', 'chapterId', 'number', 'seq', 'free', 'giveCredit', 'requireCredit', 'mediaId', 'homeworkId', 'exerciseId', 'length', 'materialNum', 'quizNum', 'learnedNum', 'viewedNum', 'startTime', 'endTime', 'memberNum', 'maxOnlineNum', 'liveProvider', 'userId', 'createdTime', 'updatedTime', 'copyId', 'testStartTime'], 'integer'],
            [['status', 'summary', 'tags', 'content', 'mediaUri', 'replayStatus', 'testMode'], 'string'],
            [['title', 'mediaName'], 'string', 'max' => 255],
            [['type'], 'string', 'max' => 64],
            [['mediaSource'], 'string', 'max' => 32],
            [['category', 'chapter', 'point'], 'string', 'max' => 548],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '课时ID',
            'courseId' => '课程',
            'chapterId' => '章节',
            'number' => '课时编号',
            'seq' => '课时在课程中的序号',
            'free' => '是否为免费课时',
            'status' => '课时状态',
            'title' => '课时标题',
            'summary' => '课时摘要',
            'tags' => '课时标签',
            'type' => '课时类型',
            'content' => '课时正文',
            'giveCredit' => '学完课时获得的学分',
            'requireCredit' => '学习课时前，需达到的学分',
            'mediaId' => '媒体文件ID',
            'mediaSource' => '文件来源',
            'mediaName' => '媒体文件名称',
            'mediaUri' => '媒体文件资源名',
            'homeworkId' => '作业iD',
            'exerciseId' => '练习ID',
            'length' => '时长',
            'materialNum' => '上传的资料数量',
            'quizNum' => '测验题目数量',
            'learnedNum' => '已学的学员数',
            'viewedNum' => '查看数',
            'startTime' => '直播课时开始时间',
            'endTime' => '直播课时结束时间',
            'memberNum' => '直播课时加入人数',
            'replayStatus' => 'Replay Status',
            'maxOnlineNum' => '直播在线人数峰值',
            'liveProvider' => 'Live Provider',
            'userId' => '发布人ID',
            'createdTime' => '创建时间',
            'updatedTime' => '最后更新时间',
            'copyId' => '复制课时id',
            'testMode' => '考试模式',
            'testStartTime' => '实时考试开始时间',
            'category' => '标签',
            'chapter' => '章节',
            'point' => '知识点',
        ];
    }

    /**
     * @inheritdoc
     * @return CourseLessonQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CourseLessonQuery(get_called_class());
    }
}
