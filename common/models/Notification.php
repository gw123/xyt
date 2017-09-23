<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "batch_notification".
 *
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property integer $fromId
 * @property string $content
 * @property string $targetType
 * @property integer $targetId
 * @property integer $createdTime
 * @property integer $published
 * @property integer $sendedTime
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'batch_notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'title', 'content', 'targetType'], 'string'],
            [['title', 'fromId', 'content', 'targetType'], 'required'],
            [['fromId', 'targetId', 'createdTime', 'published', 'sendedTime'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => '内容类型',
            'title' => '标题',
            'fromId' => '发送人Id',
            'content' => '通知内容',
            'targetType' => '通知发送对象',
            'targetId' => '目标ID',
            'createdTime' => '创建时间',
            'published' => '是否已经发送',
            'sendedTime' => '发送时间',
        ];
    }

    /**
     * @inheritdoc
     * @return NotificationQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NotificationQuery(get_called_class());
    }
}
