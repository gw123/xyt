<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\utils\Constant;

/* @var $this yii\web\View */
/* @var $model common\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

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

    <div class="row" style="margin-bottom: 12px">
        <div class="form-group">
            <div class="col-md-2">
                <label for="_category" class="label label-lg label-warning  arrowed-right"> 目录 </label>
            </div>
            <div class="col-md-10" id="_category">
                <?php
                $titles = \common\models\CategorySearch::getTitlesByIdstr($model->category);
                foreach ( $titles  as $val)   echo  Html::button($val , ['class'=>'btn btn-category' , 'disabled'=>'disabled'])." ";
                ?>
            </div>
        </div>
    </div>
    <div class="row" style="margin-bottom: 18px">
        <div class="form-group">
            <div class="col-md-2">
                <label for="_chapter" class="label label-lg label-warning  arrowed-right"> 章节 </label>
            </div>
            <div class="col-md-10" id="_chapter">
                <?php
                $titles = \common\models\ChapterSearch::getTitlesByIdstr($model->chapter);
                foreach ( $titles  as $val)   echo  Html::button($val , ['class'=>'btn btn-category' , 'disabled'=>'disabled'])." ";
                ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div  class="col-md-6">
            <div class="form-group row">
                <div class="col-md-2"><label class="label label-lg label-success  arrowed-right">点击数</label></div>
                <div  class="col-md-2"> <?= $model->pv ?> </div>
                <div class="col-md-2"><label class="label label-lg label-success  arrowed-right">回复数</label></div>
                <div  class="col-md-2"> <?= $model->postNum?> </div>
                <div class="col-md-2"><label class="label label-lg label-success  arrowed-right">点赞数</label></div>
                <div  class="col-md-2"> <?=$model->upsNum?></div>
            </div>

            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-success  arrowed-right">创建用户</label></div>
                <div  class="col-md-9"><?= common\models\User::getNickNameById($model->userId)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-pink  arrowed-right">创建时间</label></div>
                <div class="col-md-8"><?= date('Y-m-d h:i' ,$model->createdTime)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-pink  arrowed-right">发布时间</label></div>
                <div class="col-md-8"><?= date('Y-m-d h:i' ,$model->publishedTime)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-pink  arrowed-right">更新时间</label></div>
                <div class="col-md-8"><?= date('Y-m-d h:i' ,$model->updatedTime)?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-danger  arrowed-right">状态</label></div>
                <div  class="col-md-9"><?=isset( Constant::$ArticleStatus[ $model->status ] )?Constant::$ArticleStatus[ $model->status ] :"未选择状态" ?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-danger  arrowed-right">是否头条</label></div>
                <div  class="col-md-9"><?= $model->featured ? Constant::$ArticleIsTop[ $model->featured ] : "普通" ?></div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"><label class="label label-lg label-danger  arrowed-right">推荐</label></div>
                <div  class="col-md-9"><?=  $model->promoted ? Constant::$RecommenLvl[ $model->promoted ] :"普通" ?></div>
            </div>


        </div>
        <div class="col-md-6" style="text-align: center">
            <?= Html::img( $model->picture , [ 'width'=>'320' , 'height'=>'200'  ]) ?>
        </div>
    </div>

    <div class="row">
        <div class="from-group">
            <div class="col-md-12">
                <label  class="label label-lg label-danger arrowed-in">文章内容</label>
                <hr style="margin-top: -16px;height: 2px;">
            </div>

            <div class="col-md-10" style="min-height: 200px;margin-top: 10px;  width: 720px; padding-top: 10px;">
                <?=$model->body ?>
            </div>
        </div>
    </div>

    <? DetailView::widget([
        'model' => $model,
       // 'options' => ['class1' => 'table1'],
        'template' => '<tr><th  width="80">{label}</th><td>{value}</td></tr>',
        'attributes' => [
            'id',
            [ 'attribute'=>'userId', 'value'=>\common\models\User::getNickNameById($model->userId) ],
            'title',
           // 'categoryId',
           // 'tagIds:ntext',
           // 'source',
           // 'sourceUrl:url',
            // 'publishedTime:datetime',
            //'body',
            //[ 'attribute'=>'originalThumb', 'format'=>'raw', 'value'=>Html::img($model->originalThumb?$model->originalThumb:Yii::$app->params['defaultImage'] ,['width'=>480,'height'=>'320','title'=>$model->originalThumb] ) ],
            // [ 'attribute'=>'thumb', 'format'=>'raw',          'value'=>Html::img($model->thumb?$model->thumb:Yii::$app->params['defaultImage'] ,['width'=>480,'height'=>'320','title'=>$model->thumb] ) ],
            [   // 发布状态
                'attribute'=>'status',
                'value'=>$model->status ? Constant::$ArticleStatus[ $model->status ] : '普通'
            ],
            [
                'attribute'=>'featured',
                'value'=> $model->featured ? Constant::$ArticleIsTop[ $model->featured ] : "普通"
            ],
            [
                'attribute'=>'promoted',
                'value'=> $model->promoted ? Constant::$RecommenLvl[ $model->promoted ] :"普通"
            ],
            //'sticky',
            'pv',
            'postNum',
            'upsNum',
            //'userId',
            [ 'attribute'=>'publishedTime', 'value'=>date('Y-m-d h:i:s',$model->publishedTime) ],
            [ 'attribute'=>'createdTime', 'value'=>date('Y-m-d h:i:s',$model->createdTime) ],
            [ 'attribute'=>'updatedTime', 'value'=>date('Y-m-d h:i:s',$model->updatedTime) ],

            //'category',
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
            //'point',
            [ 'attribute'=>'picture', 'format'=>'raw', 'value'=>Html::img($model->picture ,['width'=>480,'height'=>'320','title'=>$model->picture] ) ],
            ['attribute'=>'body', 'format'=>'raw', 'value'=> $model->body],
        ],
    ]) ?>

</div>
