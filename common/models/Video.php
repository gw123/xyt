<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $category
 * @property string $chapter
 * @property integer $status
 * @property integer $createdTime
 * @property string $cover
 * @property string $title
 * @property string $desc
 * @property string $content
 * @property integer $updatedTime
 * @property integer $updateUid
 */
class Video extends \yii\db\ActiveRecord
{
    const  published = 'published';
    const  unpublished = 'unpublished';
    const  trash = 'trash';

    const  pass = 'pass';
    const  onpass = 'onpass';
    const  notpass = 'notpass';


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'createdTime', 'updatedTime', 'updateUid'], 'integer'],
            [['desc'], 'string'],
            [[ 'status'] ,'in','range'=>['published','unpublished','trash'] ],
            [[ 'auditStatus'] ,'in','range'=>['pass','nopass','onpass'] ],
            [['category', 'chapter', 'title', 'content'], 'string', 'max' => 128],
            [['cover'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' =>'用户',
            'category' => '目录',
            'chapter' => '章节',
            'status' => '状态',
            'createdTime' => '创建时间',
            'cover' => '封面',
            'title' => '标题',
            'desc' => '内容描述',
            'content' => '地址',
            'updatedTime' => '更新时间',
            'updateUid' => '更新用户',
            'auditStatus'=>'审核状态'
        ];
    }

    /**
     * @inheritdoc
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
    }
}
