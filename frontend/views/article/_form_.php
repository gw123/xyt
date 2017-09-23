<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\utils\Constant;
use frontend\widgets\ImageCorpWidget;
/* @var $this yii\web\View */
/* @var $model common\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/lang/zh-cn/zh-cn.js"></script>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建文章' : '更新文章', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?php  /*$form->field($model, 'point')->textInput(['maxlength' => true])*/  ?>
    <!--  章节目录选择器 --->
    <div class="form-group">
         <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Article[category]']); ?>
    </div>
    <div class="form-group">
         <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Article[chapter]']); ?>
    </div>

    <div class="form-group">
        <?=ImageCorpWidget::widget( ['name'=>'Article[picture]' ,'value'=>$model->picture,'width'=>300 ,'height'=>200 ] )?>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList( Constant::$ArticleStatus , ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'source')->dropDownList( Constant::$Source_id    ,  ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'sticky')->dropDownList([ '1' => '置顶', '2' => '不置顶' ], ['prompt' => '是否置顶']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3"><label>编辑器类型</label></div>
        <div class="col-sm-9">  <?= Html::radioList('Article[editor_type]' ,$model->editor_type?$model->editor_type: 'ueditor', [ 'ueditor' => '富文本编辑器', 'markdown' => 'markdown'] ) ?> </div>
    </div>

    <div class="row" id="editor">
        <div class="col-md-12" id="ueditor_wrap" >
            <?= $form->field($model,'body')->widget('kucha\ueditor\UEditor',[
                'clientOptions' => [
                    'initialFrameHeight' => '500',            //编辑区域大小
                    'id'=>'_body'
                ]
            ] ); ?>
        </div>
        <div class="col-md-12" id="markdown_wrap">
            <div> <input id="markdown_preview" type="button" class="btn btn-default" value="预览"  style=""> </div>
            <?= $form->field($model,'markdown')->textarea(['rows'=>20])?>

            <?= Html::tag('div','',['id'=>'preview_content'  ,'class'=>'form-control','style'=>'display:none;overflow:auto;height:28.56em;margin-bottom:15px'])?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建文章' : '更新文章', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<script>

    var ue = UE.getEditor('article-body');

    var editor_type = '<?=$model->editor_type ?>';
    if(editor_type!="markdown")
    {
        $('#ueditor_wrap').show();
        $('#markdown_wrap').hide();
    }else{
        $('#ueditor_wrap').hide();
        $('#markdown_wrap').show();
    }

    var token = "<?= Yii::$app->request->csrfToken ?>";
    $('[name="Article[editor_type]"]').click(function () {
        var value = $(this).val();
        console.log(value);
        if(value=="ueditor")
        {
            $('#ueditor_wrap').show();
            $('#markdown_wrap').hide();
        }else{
            $('#ueditor_wrap').hide();
            $('#markdown_wrap').show();
        }
    });
    // markwond 预览功能
    $('#markdown_preview').click(function () {
        var content = $('#article-markdown').val();
        var title   = $(this).val();
        if(title == '预览')
        {
            $(this).val('编辑Markdown');
            $.ajax({
                url:'/article/markdown-preview',
                data:{ 'content':content ,'_csrf-frontend':token},
                dataType:'json',
                type:'post',
                success:function(response){
                    $('#preview_content').html(response.content);
                    $('#preview_content').show();
                    $('#article-markdown').hide();
                },
                error:function () {  alert(url+"  not found !!") }
            });

        }else{
            $('#preview_content').hide();
            $('#article-markdown').show();
            $(this).val('预览');
        }

    });

</script>