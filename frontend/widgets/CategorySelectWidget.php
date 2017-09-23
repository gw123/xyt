<?php
namespace frontend\widgets;

use yii\base\Exception;
use yii\base\Widget;

/***
<?php echo CascadeSelectWidget::widget([
'model'=>$model ,
'modal_id'=>'categoryModal',
'name'=>'Chapter[category]'
]  ) ?>
 */

/***
 * Class CascadeSelectWidget
 * @package frontend\widgets
 */
class CategorySelectWidget extends Widget
{

    public  $model;
    public  $name;


    public function init()
    {
        parent::init();
        if ($this->model === null) {
            throw(new Exception('请设置model') );
        }
        if($this->name ===null)
        {
            $fromName =$this->model->formName();
            $this->name= $fromName.'[category]';
        }
    }

    public function run()
    {
        // 渲染视图
       return $this->render('@frontend/views/template/categorySelect', ['model'=>$this->model , 'name'=>$this->name]);
    }
}
?>