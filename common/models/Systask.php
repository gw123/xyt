<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "systask".
 *
 * @property integer $id
 * @property string $title
 * @property integer $type
 * @property string $exec
 * @property string $argument
 * @property integer $createdTime
 * @property integer $endTime
 * @property string $result
 * @property integer $status
 */
class Systask extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'systask';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'createdTime', 'endTime', 'status'], 'integer'],
            [['result'], 'string'],
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
            'title' => '任务标题',
            'type' => '任务类型',
            'exec' => '执行命令',
            'argument' => '参数',
            'createdTime' => '创建时间',
            'endTime' => '结束时间',
            'result' => '执行结果',
            'status' => '状态',
        ];
    }

    /**
     * @inheritdoc
     * @return SystaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SystaskQuery(get_called_class());
    }
}
