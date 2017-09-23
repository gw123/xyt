<?php

namespace common\models;
use Yii;
use common\utils\Uploader;

/**
 *
 * @property integer $id
 * @property integer $uid
 * @property string $url
 * @property integer $status
 * @property string $desc
 * @property string $title
 * @property integer $album
 * @property integer $type
 */
class Material extends \yii\db\ActiveRecord
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
    public function rules()
    {
        return [
            [['uid','pv','up' ,'createdTime','file_id','type'], 'integer'],
            [['desc','chapter','cover','category'], 'string', 'max' => 1024],
            [['title'], 'string', 'max' => 64],
            [['uid', 'status','content','createdTime','title','desc' ],'required','on'=>'create'],
            [[ 'status'] ,'in','range'=>['published','unpublished','trash'] ],
            [[ 'auditStatus'] ,'in','range'=>['pass','nopass','onpass'] ]
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        return $scenarios;
//        return [
//            'create' => ['uid', 'status', 'cover' ,'content' ,'createdTime' ,'chapter','category' ,'title','desc' , 'file_id','type'],
//            'update' => ['uid', 'status', 'cover','content' ,'chapter','updatedTime','updateUid','category' ,'title','desc' ,'type', 'file_id', 'pv','up'],
//            'normal'=>['pv','up']
//        ];
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
            'updateUidr'=>'更新用户',
            'type'=>'类型',
            'auditStatus'=>'审核状态',
            'content'=>'下载地址',
            'pv'=>'下载次数',
            'up'=>'点赞次数'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
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
