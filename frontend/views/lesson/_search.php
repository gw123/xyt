<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CourseLessonSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="course-lesson-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'courseId') ?>

    <?= $form->field($model, 'chapterId') ?>

    <?= $form->field($model, 'number') ?>

    <?= $form->field($model, 'seq') ?>

    <?php // echo $form->field($model, 'free') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'summary') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'giveCredit') ?>

    <?php // echo $form->field($model, 'requireCredit') ?>

    <?php // echo $form->field($model, 'mediaId') ?>

    <?php // echo $form->field($model, 'mediaSource') ?>

    <?php // echo $form->field($model, 'mediaName') ?>

    <?php // echo $form->field($model, 'mediaUri') ?>

    <?php // echo $form->field($model, 'homeworkId') ?>

    <?php // echo $form->field($model, 'exerciseId') ?>

    <?php // echo $form->field($model, 'length') ?>

    <?php // echo $form->field($model, 'materialNum') ?>

    <?php // echo $form->field($model, 'quizNum') ?>

    <?php // echo $form->field($model, 'learnedNum') ?>

    <?php // echo $form->field($model, 'viewedNum') ?>

    <?php // echo $form->field($model, 'startTime') ?>

    <?php // echo $form->field($model, 'endTime') ?>

    <?php // echo $form->field($model, 'memberNum') ?>

    <?php // echo $form->field($model, 'replayStatus') ?>

    <?php // echo $form->field($model, 'maxOnlineNum') ?>

    <?php // echo $form->field($model, 'liveProvider') ?>

    <?php // echo $form->field($model, 'userId') ?>

    <?php // echo $form->field($model, 'createdTime') ?>

    <?php // echo $form->field($model, 'updatedTime') ?>

    <?php // echo $form->field($model, 'copyId') ?>

    <?php // echo $form->field($model, 'testMode') ?>

    <?php // echo $form->field($model, 'testStartTime') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'chapter') ?>

    <?php // echo $form->field($model, 'point') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
