<?php
namespace frontend\widgets;

use yii\base\Exception;
use yii\base\Widget;


/***
<?php echo CascadeSelectWidget::widget([
'value'=>$model->category ,
'lvl_1_items'=>\common\models\CategorySearch::getLvl1Category(),
'srever_url'=>'/category/get-category-sons',
'modal_id'=>'categoryModal',
'name'=>'Chapter[category]'
]  ) ?>
 */

/***
 * Class CascadeSelectWidget
 * @package frontend\widgets
 */
class UploaderWidget extends Widget
{

    public  $model;
    public  $name;
    public  $modalTitle;
    public  $field;
    public  $fileType;
    public  $serverUrl;
    public  $lableTitle;

    public function init()
    {

        parent::init();

        if ($this->model === null) {
            throw( new  Exception('请设置model') );
        }
        if($this->name ===null)
        {
            $this->name= 'category';
        }
        if($this->modalTitle ===null)
        {
            $this->modalTitle= '上传文件';
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
        if($this->fileType===null)
        {
            $fileType = 'image';
        }
        if($this->serverUrl===null)
        {
            $this->serverUrl = '/uploader/upload-video';
        }
        if($this->lableTitle===null)
        {
            $this->lableTitle = '文件地址';
        }
    }

    public function run()
    {
        // 渲染视图
        return $this->render('@frontend/views/template/upload-file',
            ['model'=>$this->model , 'name'=>$this->name,'modalTitle'=>$this->modalTitle,
                'field'=>$this->field,'fileType'=>$this->fileType,
                'lableTitle'=>$this->lableTitle, 'serverUrl'=>$this->serverUrl]);
    }
}
?>