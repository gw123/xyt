<?php
namespace frontend\widgets;
use yii\base\Exception;
use yii\base\Widget;
/***
<?= MeituWidget::widget(
['name'=>'avator',
'serverUrl'=>'/uploader/upload-image',
'repaceImageId'=>'avatar'
])
?>
 */

/***
 * Class CascadeSelectWidget
 * @package frontend\widgets
 */
class MeituWidget extends Widget
{
    public  $name;
    public  $modalTitle;
    public  $field;
    public  $serverUrl;
    public  $lableTitle;
    public  $avator;
    public  $repaceImageId;
    public function init()
    {

        parent::init();

        if($this->name ===null)
        {
            $this->name= 'avator';
        }
        if($this->avator ===null)
        {
            $defaultAvatro = \Yii::$app->params['defaultAvatar'];
            $this->avator= $_SERVER['HTTP_HOST'].'/'.$defaultAvatro;
        }else{
            $this->avator= $_SERVER['HTTP_HOST'].'/'.$this->avator;
        }
        if($this->modalTitle ===null)
        {
            $this->modalTitle= '上传头像';
        }
        if($this->field===null)
        {
            if( preg_match('/\[(.*)\]/' , $this->name ,$match) )
            {
                $this->field=$match[1];
            }else{
                $this->field = $this->name;
            }
        }

        if($this->serverUrl===null)
        {
            $this->serverUrl = $_SERVER['HTTP_HOST'].'/uploader/upload-image';
        }
        if($this->lableTitle===null)
        {
            $this->lableTitle = '文件地址';
        }
    }

    public function run()
    {
        // 渲染视图
        return $this->render('@app/views/template/meitu_5',
        [ 'name'=>$this->name,'modalTitle'=>$this->modalTitle,
         'modelId'=>'meitu_model_'.$this->name,
         'hiddenId'=>'meitu_hidden_'.$this->name,
         'field'=>$this->field,
         'avator'=>$this->avator, 'serverUrl'=>$this->serverUrl,
         'repaceImageId'=>$this->repaceImageId
        ]);
    }
}
?>