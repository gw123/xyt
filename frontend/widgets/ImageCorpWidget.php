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
class ImageCorpWidget extends Widget
{
    public  $model;
    public  $name;
    public  $widgetId;
    public  $value;
    public  $height;
    public  $width;

    public function init()
    {
        if( $this->model&&$this->name )
        {
            $this->value = $this->model[ $this->name ];
            $formname = $this->model->formName();
            $this->name =$formname."[{$this->name}]";
        }
        parent::init();
    }

    public function run()
    {
        // 渲染视图
      return  $this->render('@frontend/views/template/upload-image',
            [   'name'=>$this->name ,'imageUrl'=>$this->value,
                'width'=>$this->width ,'height'=>$this->height,'widgetId'=>$this->widgetId] );
    }
}
?>