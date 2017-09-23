<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Video */
$this->title = '更新视频 ' . $model->title;
$this->params['pageTitle'] = $this->title

?>
<div class="video-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
