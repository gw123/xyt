<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\models\Chapter;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ExamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Exams';
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="exam-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Exam', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            //'keyword',
            //'keyword_type',
            'title',
            'intro:ntext',
            'mTime:datetime',
            // 'cover',
            // 'cTime',
            // 'token',
            // 'finish_tip:ntext',
            //'start_time:datetime',
            // 'end_time:datetime',
            [
                'label'=>'专辑',
                'format'=>'raw',
                'value'=>function($m){
                    //return $m->chapter;
                    $c = $m->chapter;
                    return  Chapter::getChapterNodeName($c);
                }
            ],
            // 'bookid',
            // 'status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
