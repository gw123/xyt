<link href="/css/mobile/css.css" rel="stylesheet" type="text/css">
<?php  use common\models;
use common\utils\Constant;
$chapterModel = new \common\models\Chapter();
$books = $chapterModel->getBookName();
$chapters = $chapterModel->getChapter();
//$this->registerJsFile("@web/js/handlebars-v3.0.3.js",['depends' =>[yii\web\YiiAsset::className()]]);
$this->registerCssFile('@web/css/question_list.css');
?>
<div class="paper">
    <p class="paper_title">试卷标题</p>
    <div class="paper_info"> 时间：120分钟   满分：100分</div>
</div>
<?php foreach ($questionList as $index =>$big_item){ ?>
    <?=$big_item['desc']?>
   <?php foreach ($big_item['items'] as $index =>$question){ ?>
    <div class="question" >
        <?php //选择合适的模板
        $template = $question['template'];
        $templates = ['answer','choice','fill','multi','alter'];
        if(in_array($template,$templates))
        {
            echo $this->render('./template/'.$template.'.php',['question'=>$question,'hideAnswer'=>1,'isSub'=>0]);
        }else{
            echo "template:: $template <br>";
        }

        ?>
    </div>
    <?php } ?>
<?php } ?>

