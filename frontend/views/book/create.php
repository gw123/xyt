<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Book */

$this->title = '创建书籍';
$this->params['breadcrumbs'][] = ['label' => '我的书籍', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="book-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
