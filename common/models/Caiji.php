<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "caiji".
 *
 * @property string $id
 * @property string $source_id
 * @property string $tag
 * @property string $title
 * @property string $content
 * @property string $attach
 * @property integer $status
 * @property string $url
 * @property string $createtime
 */
class Caiji extends \yii\db\ActiveRecord
{
    public  static  function  getDb()
    {
        return Yii::$app->kdb;
    }

    public static function tableName()
    {
        return 'items';
    }

    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content','contentType'], 'string'],
            [['status',  ], 'integer'],
            [['createdTime'], 'safe'],
            [['source_id'], 'string', 'max' => 20],
            [['tag'], 'string', 'max' => 100],
            [['title', 'attach', 'url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'source_id' => '来源',
            'tag' => '分类',
            'title' => '帖子标题',
            'contentType' => '类型',
            'content' => '帖子内容',
            'attach' => '关联内容',
            'status' => 'Status',
            'url' => 'Url',
            'createdTime' => '发表时间',

        ];
    }

    /**
     * @inheritdoc
     * @return CaijiQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CaijiQuery(get_called_class());
    }
}
