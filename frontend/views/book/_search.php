<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Book;
/* @var $this yii\web\View */
/* @var $model common\models\BookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>


    <div class="row">
        <div class="col-sm-4">  <?= $form->field($model, 'title') ?></div>
        <div class="col-sm-3">  <?= $form->field($model, 'status')->dropDownList(Book::Status) ?></div>
        <div class="col-sm-3">  <?= $form->field($model, 'deveStatus')->dropDownList(Book::DevStatus) ?> </div>
        <div class="col-sm-2">
            <div class="form-group">
            <label>&nbsp;</label><br>
            <?= Html::submitButton('查找', ['class' => 'from-control btn btn-sm btn-primary']) ?>
            </div>
        </div>
    </div>




    <?php // echo $form->field($model, 'collectNum') ?>
    <?php // echo $form->field($model, 'createdTime') ?>

    <?php // echo $form->field($model, 'pv') ?>

    <?php // echo $form->field($model, 'createdTime') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sort') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'isPublic') ?>

    <?php // echo $form->field($model, 'auditStatus') ?>

    <?php // echo $form->field($model, 'deveStatus') ?>





    <?php ActiveForm::end(); ?>

</div>
