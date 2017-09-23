<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Video */

$this->title = $model->title;
$this->params['pageTitle'] =$this->title;
//$this->params['breadcrumbs'][] = ['label' => '我的视频', 'url' => ['/video/index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-view">

    <p>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
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
            //'id',
            'title',
            //'uid',
            [ 'attribute'=>'userId', 'value'=>\common\models\User::getNickNameById($model->uid) ],
            //[ 'attribute'=>'updateUid', 'value'=>\common\models\User::getNickNameById($model->updateUid) ],
           // 'category',
            //'chapter',
            [
                'attribute'=>'category',
                'value'=>function($m)
                {
                    $categorys = \common\models\CategorySearch::getTitlesByIdstr($m->category);
                    return implode( ' , ' , $categorys);
                }
            ],
            [
                'attribute'=>'chapter',
                'value'=>function($m)
                {
                    $chapters = \common\models\ChapterSearch::getTitlesByIdstr($m->chapter);
                    return implode( ' , ' , $chapters);
                }
            ],
           // 'status',
            //'createdTime:datetime',
            //'cover',

            //'updatedTime:datetime',
            [ 'attribute'=>'createdTime', 'value'=>date('Y-m-d h:i:s',$model->createdTime) ],
            //[ 'attribute'=>'updatedTime', 'value'=>date('Y-m-d h:i:s',$model->updatedTime) ],
            [ 'attribute'=>'desc' , 'format'=>'raw' , 'value'=>$model->desc ],
            [ 'attribute'=>'cover', 'format'=>'raw', 'value'=>"<center>".Html::img($model->cover?$model->cover:Yii::$app->params['defaultImage'] ,['width'=>320,'height'=>'240','title'=>$model->cover] )."</center>" ],
            // 'desc:ntext',
            //[ 'attribute'=>'body',    'format'=>'raw',   'value'=> $model->desc  ],
            // 'content',
            [
                'attribute'=>'content',
                'format'=>'raw',
                'value'=> function($model)
                {
                    return '<center><video width="480" height="320" controls class="video">\
                            <source class="upload_dispaly" src="'.$model['content'].'" type="video/mp4">\
                            <object data="movie.mp4" width="480" height="320">\
                                <embed width="320" height="240" class="upload_dispaly" src="'.$model['content'].'">\
                            </object>\
                        </video></center>';
                }
            ],
           
        ],
    ]) ?>

</div>
