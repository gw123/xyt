<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "question".
 *
 * @property string $id
 * @property string $type
 * @property string $stem
 * @property double $score
 * @property string $answer
 * @property string $analysis
 * @property string $metas
 * @property string $categoryId
 * @property string $difficulty
 * @property string $target
 * @property string $parentId
 * @property string $subCount
 * @property string $finishedTimes
 * @property string $passedTimes
 * @property string $userId
 * @property string $updatedTime
 * @property string $createdTime
 * @property integer $copyId
 * @property string $category
 * @property string $chapter
 * @property string $point
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['stem', 'answer', 'analysis', 'metas'], 'string'],
            [['score'], 'number'],
            [['categoryId', 'parentId', 'subCount', 'finishedTimes', 'passedTimes', 'userId', 'updatedTime', 'createdTime', 'copyId'], 'integer'],
            [['type', 'difficulty'], 'string', 'max' => 64],
            [['target'], 'string', 'max' => 255],
            [['category', 'chapter', 'point'], 'string', 'max' => 548],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '题目ID',
            'type' => '题目类型',
            'stem' => '题干',
            'score' => '分数',
            'answer' => '参考答案',
            'analysis' => '解析',
            'metas' => '题目元信息',
            'categoryId' => '类别',
            'difficulty' => '难度',
            'target' => '从属于',
            'parentId' => '材料父ID',
            'subCount' => '子题数量',
            'finishedTimes' => '完成次数',
            'passedTimes' => '成功次数',
            'userId' => '用户id',
            'updatedTime' => '更新时间',
            'createdTime' => '创建时间',
            'copyId' => '复制问题对应Id',
            'category' => '标签',
            'chapter' => '章节',
            'point' => '知识点',
        ];
    }

    /**
     * @inheritdoc
     * @return QuestionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new QuestionQuery(get_called_class());
    }
}
