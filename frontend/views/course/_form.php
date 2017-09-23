<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Course */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true]) ?>




    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'status')->dropDownList([ 'draft' => 'Draft', 'published' => 'Published', 'closed' => 'Closed', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'buyable')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'buyExpiryTime')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'price')->textInput() ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'maxStudentNum')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'originPrice')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'coinPrice')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'originCoinPrice')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'expiryMode')->dropDownList([ 'date' => 'Date', 'days' => 'Days', 'none' => 'None', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'showStudentNumType')->dropDownList([ 'opened' => 'Opened', 'closed' => 'Closed', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'serializeMode')->dropDownList([ 'none' => 'None', 'serialize' => 'Serialize', 'finished' => 'Finished', ], ['prompt' => '']) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'income')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'lessonNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'giveCredit')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'rating')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'ratingNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'vipLevelId')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'categoryId')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'recommended')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'recommendedSeq')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'recommendedTime')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'locationId')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'parentId')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'studentNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'hitNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'noteNum')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'userId')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'discountId')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'discount')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'deadlineNotify')->dropDownList([ 'active' => 'Active', 'none' => 'None', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'daysOfNotifyBeforeDeadline')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'watchLimit')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'useInClassroom')->dropDownList([ 'single' => 'Single', 'more' => 'More', ], ['prompt' => '']) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'conversationId')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'approval')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'createdTime')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'updatedTime')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'freeStartTime')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'freeEndTime')->textInput() ?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'locked')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'maxRate')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'tryLookable')->textInput() ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'tryLookTime')->textInput() ?>
        </div>
    </div>


    <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Course[category]']); ?>
    <?= \frontend\widgets\ChapterSelectWidget::widget(['model'=>$model , 'name'=>'Course[chapter]']); ?>

    <div class="form-group">
        <?= \frontend\widgets\UploaderWidget::widget(['fileType'=>'image', 'name'=>'Course[largePicture]','model'=>$model ,
            'modalTitle'=>'选择图片','lableTitle'=>'大图','serverUrl'=>'/uploader/upload-image' ]); ?>
    </div>
    <div class="form-group">
        <?= \frontend\widgets\UploaderWidget::widget(['fileType'=>'image', 'name'=>'Course[smallPicture]','model'=>$model ,
            'modalTitle'=>'选择图片','lableTitle'=>'小图','serverUrl'=>'/uploader/upload-image' ]); ?>
    </div>


    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'teacherIds')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'goals')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'audiences')->textarea(['rows' => 6]) ?>
        </div>
    </div>
    <?= $form->field($model,'about')->widget('kucha\ueditor\UEditor',[
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

    <?= $form->field($model,'address')->widget('kucha\ueditor\UEditor',[
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
