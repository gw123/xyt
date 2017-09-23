<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\utils\Constant;
use frontend\widgets\ImageCorpWidget;
/* @var $this yii\web\View */
/* @var $model common\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '创建' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?= $form->field($model, 'title')->textInput() ?>

    <div class="form-group">
        <?= \frontend\widgets\CategorySelectWidget::widget(['model'=>$model , 'name'=>'Book[category]']); ?>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?= $form->field($model, 'status')->dropDownList(Constant::$BookStatus, ['prompt' => '']) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?= $form->field($model, 'deveStatus')->dropDownList(Constant::$BookDevStatus, ['prompt' => '']) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?= $form->field($model, 'price')->textInput(['placeholder'=>'默认为免费']) ?>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <?=ImageCorpWidget::widget( ['name'=>'Book[cover]' ,'value'=>$model->cover,'width'=>240 ,'height'=>300 ] )?>

    <?= $form->field($model, 'desc')->textarea(['maxlength' => true ,'rows'=>6 ]) ?>

    <?php ActiveForm::end(); ?>

</div>
