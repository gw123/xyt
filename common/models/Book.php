<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property integer $userId
 * @property string $title
 * @property string $cover
 * @property string $desc
 * @property integer $collectNum
 * @property integer $pv
 * @property integer $createdTime
 * @property string $code
 * @property integer $price
 * @property integer $sort
 * @property string $category
 * @property string $status
 * @property string $isPublic
 * @property string $auditStatus
 * @property string $deveStatus
 */
class Book extends \yii\db\ActiveRecord
{
    const  published = 'published';
    const  unpublished = 'unpublished';
    const  trash = 'trash';

    const  pass = 'pass';
    const  onpass = 'onpass';
    const  notpass = 'notpass';

    const  ondeve = 'ondeve';
    const  over = 'over';

    const  AllStatus = [ self::published=>'公开',self::unpublished=>'未公开',self::trash=>'已删除'];
    const  Status = [ '0'=>'全部', self::published=>'公开',self::unpublished=>'未公开'];
    const  DevStatus = [ '0'=>'全部',self::ondeve=>'正在连载',self::over=>'已经完结'];
    const  AuditStatus = ['0'=>'全部',self::pass=>'通过',self::notpass=>'未通过',self::onpass=>'正在审核'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'desc'], 'required'],
            [['userId', 'collectNum', 'pv', 'createdTime', 'price', 'sort'], 'integer'],
            [['title'], 'string', 'max' => 64],
            [['cover', 'category'], 'string', 'max' => 128],
            [['desc'], 'string', 'max' => 1024],
            [['code'], 'string', 'max' => 32],
            [[ 'status'] ,'in','range'=>['published','unpublished','trash'] ],
            [[ 'auditStatus'] ,'in','range'=>['pass','nopass','onpass'] ],
            [['deveStatus'],'in','range'=>['ondeve','over']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => '用户',
            'title' => '书籍名称',
            'cover' => '封面',
            'desc' => '描述',
            'collectNum' => '收藏人数',
            'pv' => '阅读人数',
            'createdTime' => '创建时间',
            'code' => '查看码',
            'price' => '价格',
            'sort' => '排序',
            'category' => '目录',
            'status' => '状态',
            'isPublic' => '是否开放',
            'auditStatus' => '审核状态',
            'deveStatus' => '更新状态',
            'updatedTime'=>'更新时间'
        ];
    }

    public function __toString()
    {
        return $this->title;
    }
}
