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
class CategoryTreeNavWidget extends Widget
{
    public  $categoryTree=[];
    public  $url = '';
    public function init()
    {
        parent::init();
        if( !is_array($this->categoryTree) )
        {
            $this->categoryTree= [];
        }
    }

    public function run()
    {
        // 渲染视图
        return $this->render('@app/views/template/categoryTreeNav', ['tree'=>$this->categoryTree , 'url'=>$this->url]);
    }
}
?>