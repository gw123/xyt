<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Point */

$this->title = '创建知识点';
$this->params['breadcrumbs'][] = ['label' => 'Points', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="point-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
