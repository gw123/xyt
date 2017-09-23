<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Material */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-view">

    <h1><?= Html::encode($this->title) ?></h1>

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

            'title',
            [ 'attribute'=>'uid', 'value'=>\common\models\User::getNickNameById($model->uid) ],
            'up',
            'pv',
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
            [
                'attribute'=>'status',
                'value'=> function($model)
                {
                     return \common\utils\Constant::$MaterialStatus[$model->status];
                }
            ],
            [
                'attribute'=>'auditStatus',
                'value'=> function($model)
                {
                    return \common\utils\Constant::$MaterialAuditStatus[$model->auditStatus];
                }
            ],

           // 'cover',
            //'content',
            [
                'attribute'=>'content',
                'format'=>'raw',
                'value'=>function($model){
                  $url = "http://".$_SERVER['SERVER_NAME'].$model->content;
                  return  Html::a('点击查看',$url);
                 }
            ],
            [ 'attribute'=>'createdTime', 'value'=>date('Y-m-d h:i:s',$model->createdTime) ],
            [ 'attribute'=>'updatedTime', 'value'=>date('Y-m-d h:i:s',$model->updatedTime) ],
            //'updateUid',

            // 'file_id',
            [
                'attribute'=>'cover',
                'format'=>'raw',
                'value'=>function($m)
                {
                    return "<img src='{$m->cover}' width='320' height='240'>";
                }
            ],
            //'desc:ntext',
            ['attribute'=>'desc', 'format'=>'raw', 'value'=> $model->desc],
        ],
    ]) ?>

</div>
