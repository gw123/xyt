<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Point */

$this->title = '更新知识点: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="point-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
