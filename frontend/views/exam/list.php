<?php  use common\models;
        use common\utils\Constant;
$chapterModel = new \common\models\Chapter();
$books = $chapterModel->getBookName();
$chapters = $chapterModel->getChapter();
//$this->registerJsFile("@web/js/handlebars-v3.0.3.js",['depends' =>[yii\web\YiiAsset::className()]]);
$this->registerCssFile('@web/css/question_list.css');
?>

<?php foreach ($questionList as $index =>$question){ ?>
    <div class="question" >
        <div class="question_info">
            <div> 题号： <? echo  $question['id'] ?>  </div>
<!--            <div title="--><?// echo $books[ $question['bookname'] ] ?><!--"> 教材：--><?// echo   $books[ $question['bookname'] ] ?><!--  </div>-->
<!--            <div title="--><?// echo   $chapters[ $question['chapter'] ] ?><!-- "> 章节：--><?// echo   $chapters[ $question['chapter'] ] ?><!--  </div>-->
<!--            <div title="--><?// $question['point']  ?><!--"> 知识点：--><?// echo $question['point'] ?><!--  </div>-->
<!--            <div> 难度：--><?// echo $question['difficulty']  ?><!--  </div>-->
<!--            <div> 重要性：--><?// echo $question['importance']  ?><!--  </div>-->
            <div> 题型：  <? echo  Constant::$QUESTION_TYPES[ $question['type'] ] ?>  </div>
            <div> 创建时间：<? echo date('Y-m-d',$question['ctime']); ?>  </div>
        </div>
        <div style="clear: both"></div>

        <?php //选择合适的模板
        $template = $question['template'];
        $templates = ['answer','choice','fill','multi','alter'];
        if(in_array($template,$templates))
        {
            echo $this->render('./template/'.$template.'.php',['question'=>$question]);
         }else{
             echo "template:: $template <br>";
        }

        ?>

    </div>
<?php } ?>

