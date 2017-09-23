<?php
namespace frontend\widgets;

use yii\base\Exception;
use yii\base\Widget;
use yii\helpers\Html;
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
class CascadeSelectWidget extends Widget
{

    public  $model;

    public function init()
    {
        parent::init();
        if ($this->model === null) {
            throwException( Exception('请设置model') );
        }
    }


    public function run()
    {
        // 渲染视图
       return $this->render('@frontend/views/template/cascadeSelect', ['model'=>$this->model]);
    }
}
?>