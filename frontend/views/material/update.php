<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Material */

$this->title = '更新资料: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => '资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
