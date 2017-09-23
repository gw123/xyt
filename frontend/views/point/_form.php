<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use \kucha\ueditor\UEditor;

/* @var $this yii\web\View */
/* @var $model common\models\Point */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="point-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList(\common\utils\Constant::$PointStatus, ['prompt'=>'请选择','style'=>'width:120px']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Point[category]']); ?>
    <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Point[chapter]']); ?>
    <div class="form-group">
        <?= \frontend\widgets\UploaderWidget::widget(['fileType'=>'image', 'name'=>'Point[cover]','model'=>$model ,
            'modalTitle'=>'选择图片','lableTitle'=>'图片地址','serverUrl'=>'/uploader/upload-image' ]); ?>
    </div>


    <?= $form->field($model,'desc')->widget('kucha\ueditor\UEditor',[
        'clientOptions' => [
            'initialFrameHeight' => '200',            //编辑区域大小
            'toolbars' => [            //定制菜单
                [
                    'fullscreen', 'source', 'undo', 'redo', '|',
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
    <?php ActiveForm::end(); ?>

</div>
<script>
    $('#point-cover').click(function () {
        $('.edui-for-scrawl .edui-button-body')[0].click();
       // $(".edui-for-insertimage .edui-button-body")[0].click();
    });
   // UploaderServer({btn_show:'.changeImage', input_save_url:'#_cover' ,serverUrl:'/uploader/upload-file'});
</script>