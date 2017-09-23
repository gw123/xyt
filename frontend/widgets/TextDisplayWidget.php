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
class TextDisplayWidget extends Widget
{
    public  $content;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        // 渲染视图
        return "<div style='max-width: 800px;margin: 0 auto;text-indent: 2em'>".$this->content."</div>";
    }
}
?>