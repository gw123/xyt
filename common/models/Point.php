<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "point".
 *
 * @property integer $id
 * @property integer $uid
 * @property string $category
 * @property string $chapter
 * @property integer $status
 * @property integer $createTime
 *  @property integer $updatedTime
 *  @property integer $updateUid
 * @property integer $cover
 * @property string $title
 * @property string $desc
 */
class Point extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'point';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'status', 'createdTime' ,'updateUid','updatedTime'], 'integer'],
            [['desc' ,'status','uid' ,'category' ,'chapter','title'], 'required'],
            [['desc' ,'cover'], 'string'],
            [['category', 'chapter', 'title'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '用户',
            'category' => '目录',
            'chapter' => '章节',
            'status' => '状态',
            'createdTime' => '创建时间',
            'cover' => '封面',
            'title' => '标题',
            'desc' => '内容描述',
            'updatedTime'=>'更新时间',
            'updateUidr'=>'更新用户'
        ];
    }

    /**
     * @inheritdoc
     * @return PointQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PointQuery(get_called_class());
    }
}
