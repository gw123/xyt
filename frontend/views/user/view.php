<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'email:email',
            'verifiedMobile',
            'password',
            'salt',
            'payPassword',
            'payPasswordSalt',
            'locale',
            'uri',
            'nickname',
            'title',
            'tags',
            'type',
            'point',
            'coin',
            'smallAvatar',
            'mediumAvatar',
            'largeAvatar',
            'emailVerified:email',
            'setup',
            'roles',
            'promoted',
            'promotedSeq',
            'promotedTime',
            'locked',
            'lockDeadline',
            'consecutivePasswordErrorTimes:datetime',
            'lastPasswordFailTime:datetime',
            'loginTime:datetime',
            'loginIp',
            'loginSessionId',
            'approvalTime',
            'approvalStatus',
            'newMessageNum',
            'newNotificationNum',
            'createdIp',
            'createdTime',
            'updatedTime',
            'inviteCode',
            'orgId',
            'orgCode',
            'registeredWay',
            'auth_key',
            'password_hash',
            'password_reset_token',
        ],
    ]) ?>

</div>
