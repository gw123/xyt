<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'subtitle') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'buyable') ?>

    <?php // echo $form->field($model, 'buyExpiryTime') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'maxStudentNum') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'originPrice') ?>

    <?php // echo $form->field($model, 'coinPrice') ?>

    <?php // echo $form->field($model, 'originCoinPrice') ?>

    <?php // echo $form->field($model, 'expiryMode') ?>

    <?php // echo $form->field($model, 'expiryDay') ?>

    <?php // echo $form->field($model, 'showStudentNumType') ?>

    <?php // echo $form->field($model, 'serializeMode') ?>

    <?php // echo $form->field($model, 'income') ?>

    <?php // echo $form->field($model, 'lessonNum') ?>

    <?php // echo $form->field($model, 'giveCredit') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <?php // echo $form->field($model, 'ratingNum') ?>

    <?php // echo $form->field($model, 'vipLevelId') ?>

    <?php // echo $form->field($model, 'categoryId') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'smallPicture') ?>

    <?php // echo $form->field($model, 'middlePicture') ?>

    <?php // echo $form->field($model, 'largePicture') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'teacherIds') ?>

    <?php // echo $form->field($model, 'goals') ?>

    <?php // echo $form->field($model, 'audiences') ?>

    <?php // echo $form->field($model, 'recommended') ?>

    <?php // echo $form->field($model, 'recommendedSeq') ?>

    <?php // echo $form->field($model, 'recommendedTime') ?>

    <?php // echo $form->field($model, 'locationId') ?>

    <?php // echo $form->field($model, 'parentId') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'studentNum') ?>

    <?php // echo $form->field($model, 'hitNum') ?>

    <?php // echo $form->field($model, 'noteNum') ?>

    <?php // echo $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'discountId') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'deadlineNotify') ?>

    <?php // echo $form->field($model, 'daysOfNotifyBeforeDeadline') ?>

    <?php // echo $form->field($model, 'watchLimit') ?>

    <?php // echo $form->field($model, 'useInClassroom') ?>

    <?php // echo $form->field($model, 'singleBuy') ?>

    <?php // echo $form->field($model, 'createdTime') ?>

    <?php // echo $form->field($model, 'updatedTime') ?>

    <?php // echo $form->field($model, 'freeStartTime') ?>

    <?php // echo $form->field($model, 'freeEndTime') ?>

    <?php // echo $form->field($model, 'approval') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'maxRate') ?>

    <?php // echo $form->field($model, 'tryLookable') ?>

    <?php // echo $form->field($model, 'tryLookTime') ?>

    <?php // echo $form->field($model, 'conversationId') ?>

    <?php // echo $form->field($model, 'orgId') ?>

    <?php // echo $form->field($model, 'orgCode') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'chapter') ?>

    <?php // echo $form->field($model, 'point') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
