<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CourseLesson */

$this->title = 'Update Course Lesson: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="course-lesson-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
