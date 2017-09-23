<?php

namespace common\models;

use Yii;
use kucha\ueditor\Uploader;

/**
 * This is the model class for table "file".
 *
 * @property string $id
 * @property string $groupId
 * @property string $userId
 * @property string $uri
 * @property string $mime
 * @property string $size
 * @property integer $status
 * @property string $createdTime
 * @property integer $uploadFileId
 * @property string $chapter
 * @property string $path
 * @property string $cotegory
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['groupId', 'userId', 'size', 'status', 'createdTime', 'uploadFileId'], 'integer'],
            [['uri', 'mime'], 'required'],
            [['uri', 'mime'], 'string', 'max' => 255],
            [['chapter', 'cotegory'], 'string', 'max' => 548],
            [['path'], 'string', 'max' => 256],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '上传文件ID',
            'groupId' => '上传文件组ID',
            'userId' => '上传人ID',
            'uri' => '文件URI',
            'mime' => '文件MIME',
            'size' => '文件大小',
            'status' => '文件状态',
            'createdTime' => '文件上传时间',
            'uploadFileId' => 'Upload File ID',
            'chapter' => '章节',
            'path' => '路径',
            'cotegory' => '类别',
        ];
    }

    /**
     * @inheritdoc
     * @return FileQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FileQuery(get_called_class());
    }

    public  static  function getFlieRealPath($uri)
    {
        $uri = str_replace('public://' , '/files/', $uri);
        return $uri;
    }

    //上传文件
    public  function  upfile($file_type='file')
    {
        $type =  strtolower(strrchr($_FILES['file']['name'], '.'));
        $venderPath = Yii::getAlias('@vendor');
        $config = require_once ($venderPath."/kucha/ueditor/config.php");
        //var_dump($config); exit();
        if($file_type=='image'&&in_array($type,$config['imageAllowFiles']))
        {
            $_config = array(
                "pathFormat" => $config['imagePathFormat'],
                "maxSize" => $config['imageMaxSize'],
                "allowFiles" => $config['imageAllowFiles'],
                'urlPrefix'=>$config['imageUrlPrefix'],
            );
        }else if($file_type=='video'&&in_array($type,$config['videoAllowFiles']))
        {
            $_config = array(
                "pathFormat" => $config['videoPathFormat'],
                "maxSize" => $config['videoMaxSize'],
                "allowFiles" => $config['videoAllowFiles'],
                'urlPrefix'=>$config['videoUrlPrefix'],
            );
        }else if($file_type=='file'&&in_array($type,$config['fileAllowFiles'])){
            $_config = array(
                "pathFormat" => $config['filePathFormat'],
                "maxSize" => $config['fileMaxSize'],
                "allowFiles" => $config['fileAllowFiles'],
                'urlPrefix'=>$config['fileUrlPrefix'],
            );
        }
        $_config ['pathRoot'] = $config['pathRoot'];
        $info = [];
        if(empty($_config))
        {
            $info['state'] = '文件类型有问题';
            return $info;
        }

        $uploader = new Uploader( 'file' , $_config );
        $info =  $uploader->getFileInfo();
        if($info['state']!='SUCCESS')
        {
            return $info;
        }
        //$this->title = $info['title'];
        $this->mime = str_replace('.' ,'' ,$info['type'] );
        $this->size = $info['size'];
        $this->uri = "public:/".$info['url'];
        $this->createdTime = time();
        //$this->uri = $info;
        if($this->save())
        {
            return $info;
        }else{
            $info['state'] ='保存失败';
            return $info;
        }

    }

}
