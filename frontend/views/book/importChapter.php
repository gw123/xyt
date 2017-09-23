<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "章节管理";
$this->params['breadcrumbs'][] = ['label' => '我的书籍', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php if(isset($error)&&$error) {?>
<div id="responseMsg" class="alert alert-warning" >
    <button type="button" class="close" data-dismiss="alert"><i class="icon-remove"></i></button>
   <h5>  </h5>
</div>
<? } ?>

<div class="widget-box">
    <div class="widget-header header-color-dark">
        <h5 class="bigger lighter"><?=$bookName?></h5>
        <button class="pull-right  btn-warning btn-sm" onclick="window.history.go(-1)">返回</button>
        <button class="pull-right  btn-warning btn-sm" onclick="importChapter()">导入</button>
    </div>

    <div class="widget-body">
        <div class="widget-main">
            <form id="importChpaterForm" action="/chapter/import-chapter" method="post">
                 <textarea id="chapterContent" name="chapterContent" rows="30" style="width: 100%"></textarea>
                 <input type="hidden" name="bookId" value="<?=Yii::$app->request->get('id')?>">

            </form>
        </div>
    </div>
</div>
<!-- 自定义的操作dom 元素的方法最好放到最后面 -->
<script type="text/javascript" src= '/js/api.js'></script>

<script>
    function importChapter() {
        var formDataArr = $("#importChpaterForm").serializeArray();
        console.log(formDataArr)
        var formData = {};
        for(var i in formDataArr)
        {
            formData[formDataArr[i]['name'] ] =   formDataArr[i]['value'] ;
        }
        console.log(formData)
        ChapterService.importChapter(function (response) {
            if(response.status==1)
            {
               window.location.href = "/book/chapter";
            }else{
              $("#responseMsg h5").text(response.msg);
            }
            $("#responseMsg h5").show();
        },formData);
    }
</script>


