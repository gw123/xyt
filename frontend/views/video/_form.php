<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \frontend\widgets\ImageCorpWidget;
use common\utils\Constant;
/* @var $this yii\web\View */
/* @var $model common\models\Video */
/* @var $form yii\widgets\ActiveForm */
?>

<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/lang/zh-cn/zh-cn.js"></script>
<div class="video-form">
    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '上传视频' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Video[category]']); ?>
    <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Video[chapter]']); ?>

    <?= $form->field($model, 'status')->dropDownList(Constant::$VideoStatus, ['prompt'=>'','style'=>'width:160px']) ?>
    <div class="form-group">
        <?= \frontend\widgets\UploaderWidget::widget(['fileType'=>'video', 'name'=>'Video[content]','model'=>$model ,'modalTitle'=>'上传视频' ]); ?>
    </div>
    <div class="form-group">
        <?=ImageCorpWidget::widget( ['name'=>'Video[cover]' ,'value'=>$model->cover,'width'=>300 ,'height'=>200 ] )?>
    </div>

    <?= $form->field($model,'desc')->widget('kucha\ueditor\UEditor',[
        'clientOptions' => [
            'initialFrameHeight' => '120',            //编辑区域大小
            'toolbars' => [            //定制菜单
                [
                    'undo', 'redo', '|',
                    'fontsize',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'removeformat',
                    'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|',
                    'forecolor', 'backcolor', '|',
                    'lineheight', '|',
                    'indent', '|'
                ],
            ]
        ]
    ] ); ?>
    <div style="margin-bottom: 60px;clear: both"></div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    var ue = UE.getEditor('video-desc');
    var videoServer = UploaderServer({btn_show:'#fileUploader',input_save_url:'#file_url' ,serverUrl:'/uploader/upload-video'});
</script>

