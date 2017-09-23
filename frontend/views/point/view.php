<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\utils\Constant;
/* @var $this yii\web\View */
/* @var $model common\models\Point */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
     .label-height { line-height:34px;  }
    .row{ margin-bottom: 20px;}
</style>
<div class="point-view">

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

    <div class="row">
        <div class="form-group">
            <div class="col-md-1">
                <label for="_category" class="label-height"> 目录 </label>
            </div>
            <div class="col-md-5" id="_category">
                <?php
                $titles = \common\models\CategorySearch::getTitlesByIdstr($model->category);
                foreach ( $titles  as $val)   echo  Html::button($val , ['class'=>'btn btn-category' , 'disabled'=>'disabled'])." ";
                ?>
            </div>

            <div class="col-md-1">
                <label for="_chapter" class="label-height"> 章节 </label>
            </div>
            <div class="col-md-5" id="_chapter">
                <?php
                $titles = \common\models\ChapterSearch::getTitlesByIdstr($model->chapter);
                foreach ( $titles  as $val)   echo  Html::button($val , ['class'=>'btn btn-category' , 'disabled'=>'disabled'])." ";
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div  class="col-md-6">
            <div class="from-group row">
                <div class="col-md-3"><label>创建用户</label></div>
                <div  class="col-md-9"><?= common\models\User::getNickNameById($model->uid)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label>创建时间</label></div>
                <div class="col-md-8"><?= date('Y-m-d h:i' ,$model->createdTime)?></div>
            </div>
            <div class="from-group row">
                <div class="col-md-3"><label>更新用户</label></div>
                <div  class="col-md-9"><?= common\models\User::getNickNameById($model->updateUid)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label>更新时间</label></div>
                <div class="col-md-8"><?= date('Y-m-d h:i' ,$model->updatedTime)?></div>
            </div>
            <div class="from-group row">
                <div class="col-md-3"><label>状态</label></div>
                <div  class="col-md-9"><?= isset(Constant::$PointStatus[$model->status])? Constant::$PointStatus[$model->status] :'未选择状态'?></div>
            </div>

        </div>
        <div class="col-md-6" style="text-align: center">
            <?= Html::img( $model->cover , [ 'width'=>'320' , 'height'=>'200'  ]) ?>
        </div>

    </div>

    <div class="row">
        <div class="from-group">

            <div class="col-md-12">
                <label>文章内容</label>
            </div>
            <div class="col-md-12" style="min-height: 200px">
                  <?=$model->desc ?>
            </div>
        </div>
    </div>

</div>
