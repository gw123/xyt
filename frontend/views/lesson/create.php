<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CourseLesson */

$this->title = 'Create Course Lesson';
$this->params['breadcrumbs'][] = ['label' => 'Course Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-lesson-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
