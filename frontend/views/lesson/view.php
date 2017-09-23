<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CourseLesson */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Course Lessons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-lesson-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'courseId',
            'chapterId',
            'number',
            'seq',
            'free',
            'status',
            'title',
            'summary:ntext',
            'tags:ntext',
            'type',
            [
                'label'=>'课程内容',
                'format'=>'raw',
                'value'=>function($m){
                    return $m->content;
                }
            ],
            //'content:ntext',
            'giveCredit',
            'requireCredit',
            'mediaId',
            'mediaSource',
            'mediaName',
            'mediaUri:ntext',
            'homeworkId',
            'exerciseId',
            'length',
            'materialNum',
            'quizNum',
            'learnedNum',
            'viewedNum',
            'startTime',
            'endTime',
            'memberNum',
            'replayStatus',
            'maxOnlineNum',
            'liveProvider',
            'userId',
            'createdTime',
            'updatedTime',
            'copyId',
            'testMode',
            'testStartTime:datetime',
            'chapter',
            'point',
        ],
    ]) ?>

</div>
