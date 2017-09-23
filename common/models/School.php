<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "school".
 *
 * @property integer $id
 * @property string $schoolcode
 * @property string $schoolname
 * @property integer $schoolid
 * @property integer $clicks
 * @property integer $monthclicks
 * @property integer $weekclicks
 * @property string $province
 * @property string $schooltype
 * @property string $schoolproperty
 * @property string $edudirectly
 * @property integer $f985
 * @property integer $f211
 * @property string $level
 * @property integer $autonomyrs
 * @property integer $library
 * @property string $membership
 * @property integer $schoolnature
 * @property string $shoufei
 * @property string $jianjie
 * @property integer $ranking
 * @property integer $rankingCollegetype
 * @property string $guanwang
 * @property string $oldname
 * @property integer $ads
 * @property integer $center
 * @property integer $master
 * @property integer $num
 */
class School extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'school';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['schoolid', 'clicks', 'monthclicks', 'weekclicks', 'f985', 'f211', 'autonomyrs', 'library', 'schoolnature', 'ranking', 'rankingCollegetype', 'ads', 'center', 'master', 'num'], 'integer'],
            [['schoolcode', 'schooltype', 'schoolproperty', 'edudirectly'], 'string', 'max' => 20],
            [['schoolname', 'oldname'], 'string', 'max' => 48],
            [['province'], 'string', 'max' => 28],
            [['level'], 'string', 'max' => 10],
            [['membership'], 'string', 'max' => 64],
            [['shoufei', 'jianjie'], 'string', 'max' => 2048],
            [['guanwang'], 'string', 'max' => 128],
            [['schoolcode'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'schoolcode' => '学校编号',
            'schoolname' => '校名',
            'schoolid' => 'Schoolid',
            'clicks' => '点击量',
            'monthclicks' => '月点击量',
            'weekclicks' => '周点击量',
            'province' => '所在省',
            'schooltype' => '学校类型',
            'schoolproperty' => '学校属性',
            'edudirectly' => '教研部',
            'f985' => '958',
            'f211' => '211',
            'level' => '等级',
            'autonomyrs' => 'Autonomyrs',
            'library' => '图书馆数量',
            'membership' => '教育委员会',
            'schoolnature' => '公办',
            'shoufei' => '收费信息',
            'jianjie' => '简介',
            'ranking' => '学校排行',
            'rankingCollegetype' => 'Ranking Collegetype',
            'guanwang' => '学校官网',
            'oldname' => '旧名',
            'ads' => 'Ads',
            'center' => 'Center',
            'master' => 'Master',
            'num' => 'Num',
        ];
    }

    /**
     * @inheritdoc
     * @return SchoolQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SchoolQuery(get_called_class());
    }
}
