<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "groups".
 *
 * @property string $id
 * @property string $title
 * @property string $about
 * @property string $logo
 * @property string $backgroundLogo
 * @property string $status
 * @property string $memberNum
 * @property string $threadNum
 * @property string $postNum
 * @property string $ownerId
 * @property string $createdTime
 * @property string $tag
 * @property string $chapter
 * @property string $point
 */
class Group extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'groups';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'ownerId', 'createdTime'], 'required'],
            [['about', 'status'], 'string'],
            [['memberNum', 'threadNum', 'postNum', 'ownerId', 'createdTime'], 'integer'],
            [['title', 'logo', 'backgroundLogo'], 'string', 'max' => 100],
            [['tag', 'chapter', 'point'], 'string', 'max' => 548],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '小组id',
            'title' => '小组名称',
            'about' => '小组介绍',
            'logo' => 'logo',
            'backgroundLogo' => 'Background Logo',
            'status' => 'Status',
            'memberNum' => 'Member Num',
            'threadNum' => 'Thread Num',
            'postNum' => 'Post Num',
            'ownerId' => '小组组长id',
            'createdTime' => '创建小组时间',
            'tag' => '标签',
            'chapter' => '章节',
            'point' => '知识点',
        ];
    }

    /**
     * @inheritdoc
     * @return GroupQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new GroupQuery(get_called_class());
    }
}
