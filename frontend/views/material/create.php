<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Material */

$this->title = '新建资料';
$this->params['breadcrumbs'][] = ['label' => '新建资料', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
