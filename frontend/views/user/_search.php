<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SearchUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'verifiedMobile') ?>

    <?= $form->field($model, 'password') ?>

    <?= $form->field($model, 'salt') ?>

    <?php // echo $form->field($model, 'payPassword') ?>

    <?php // echo $form->field($model, 'payPasswordSalt') ?>

    <?php // echo $form->field($model, 'locale') ?>

    <?php // echo $form->field($model, 'uri') ?>

    <?php // echo $form->field($model, 'nickname') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'point') ?>

    <?php // echo $form->field($model, 'coin') ?>

    <?php // echo $form->field($model, 'smallAvatar') ?>

    <?php // echo $form->field($model, 'mediumAvatar') ?>

    <?php // echo $form->field($model, 'largeAvatar') ?>

    <?php // echo $form->field($model, 'emailVerified') ?>

    <?php // echo $form->field($model, 'setup') ?>

    <?php // echo $form->field($model, 'roles') ?>

    <?php // echo $form->field($model, 'promoted') ?>

    <?php // echo $form->field($model, 'promotedSeq') ?>

    <?php // echo $form->field($model, 'promotedTime') ?>

    <?php // echo $form->field($model, 'locked') ?>

    <?php // echo $form->field($model, 'lockDeadline') ?>

    <?php // echo $form->field($model, 'consecutivePasswordErrorTimes') ?>

    <?php // echo $form->field($model, 'lastPasswordFailTime') ?>

    <?php // echo $form->field($model, 'loginTime') ?>

    <?php // echo $form->field($model, 'loginIp') ?>

    <?php // echo $form->field($model, 'loginSessionId') ?>

    <?php // echo $form->field($model, 'approvalTime') ?>

    <?php // echo $form->field($model, 'approvalStatus') ?>

    <?php // echo $form->field($model, 'newMessageNum') ?>

    <?php // echo $form->field($model, 'newNotificationNum') ?>

    <?php // echo $form->field($model, 'createdIp') ?>

    <?php // echo $form->field($model, 'createdTime') ?>

    <?php // echo $form->field($model, 'updatedTime') ?>

    <?php // echo $form->field($model, 'inviteCode') ?>

    <?php // echo $form->field($model, 'orgId') ?>

    <?php // echo $form->field($model, 'orgCode') ?>

    <?php // echo $form->field($model, 'registeredWay') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
