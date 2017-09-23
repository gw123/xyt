<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\utils\Constant;
/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => '我的书籍', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-view">

    <p>
        <?= Html::a('章节管理', ['chapter', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('更新', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <br>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'title',
            [ 'attribute'=>'userId', 'value'=>\common\models\User::getNickNameById($model->userId) ],
            [ 'attribute'=>'createdTime', 'value'=>date('Y-m-d h:i:s',$model->createdTime) ],
            [ 'attribute'=>'updatedTime', 'value'=>date('Y-m-d h:i:s',$model->updatedTime) ],
            ['attribute'=>'status','value'=>Constant::$BookStatus[$model->status]],
            ['attribute'=>'deveStatus','value'=>Constant::$BookDevStatus[$model->deveStatus]],
            ['attribute'=>'auditStatus','value'=>Constant::$BookAuditStatus[$model->auditStatus]],
            'collectNum',
            'pv',
            'code',
            'price',
            [
                'attribute'=>'category',
                'value'=>function($m)
                {
                    $categorys = \common\models\CategorySearch::getTitlesByIdstr($m->category);
                    return implode( ' , ' , $categorys);
                }
            ],
            [ 'attribute'=>'cover', 'format'=>'raw',
                'value'=>"<center>".Html::img($model->cover?$model->cover:Yii::$app->params['defaultImage'] ,['width'=>240,'height'=>300,'title'=>$model->cover] )."</center>" ],

           // 'sort',
            ['attribute'=>'desc' , 'format'=>'raw','value'=>\frontend\widgets\TextDisplayWidget::widget(['content'=>$model->desc]) ]

        ],
    ]) ?>

</div>
