<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task_tpl".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $exec
 * @property string $argument
 */
class TaskTpl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'task_tpl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['title'], 'string', 'max' => 128],
            [['exec', 'argument'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'type' => '类型',
            'exec' => '执行命令',
            'argument' => '参数',
        ];
    }
}
