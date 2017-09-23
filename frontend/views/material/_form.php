<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\widgets\ImageCorpWidget;
use common\utils\Constant;
/* @var $this yii\web\View */
/* @var $model common\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/lang/zh-cn/zh-cn.js"></script>
<div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList( Constant::$MaterialStatus, ['prompt'=>'请选择','style'=>'width:120px']) ?>

    <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Material[category]']); ?>
    <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Material[chapter]']); ?>
    <div class="form-group">
        <?=ImageCorpWidget::widget( ['name'=>'Material[cover]' ,'value'=>$model->cover,'width'=>300 ,'height'=>200 ] )?>
    </div>
    <div class="form-group">
        <?= \frontend\widgets\UploaderWidget::widget(['fileType'=>'file', 'name'=>'Material[content]','model'=>$model ,
            'modalTitle'=>'选择文件','lableTitle'=>'文件地址','serverUrl'=>'/uploader/upfile' ]); ?>

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

    <script>
        var ue = UE.getEditor('material-desc');
    </script>

</div>
