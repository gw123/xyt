<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseLesson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-lesson-form">


    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Lesson[category]']); ?>
    <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Lesson[chapter]']); ?>
    <!--    --><?//= $form->field($model, 'point')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'seq')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'free')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList([ 'unpublished' => 'Unpublished', 'published' => 'Published', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'mediaName')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'materialNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'mediaUri')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'testMode')->dropDownList([ 'normal' => 'Normal', 'realTime' => 'RealTime', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'testStartTime')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'viewedNum')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'replayStatus')->dropDownList([ 'ungenerated' => 'Ungenerated', 'generating' => 'Generating', 'generated' => 'Generated', 'videoGenerated' => 'VideoGenerated', ], ['prompt' => '']) ?>
        </div>
    </div>

    <?= $form->field($model,'summary')->widget('kucha\ueditor\UEditor',[
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
    <?= $form->field($model,'content')->widget('kucha\ueditor\UEditor',[
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
