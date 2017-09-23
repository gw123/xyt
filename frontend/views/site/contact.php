<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
AppAsset::register($this);
$this->title = '联系我们';
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $this->beginPage() ?>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>校园通</title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- basic styles -->
    <![endif]-->
    <!-- page specific plugin styles -->
    <!-- ace styles -->
    <link rel="stylesheet" href="/home/css/ace.min.css" />
    <link rel="stylesheet" href="/home/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/home/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/home/css/ace-ie.min.css" />
    <![endif]-->
</head>
<?php $this->beginBody() ?>


<body style="background-color: #fff">

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
         <div class="site-contact">
            <h1><?= Html::encode($this->title) ?></h1>
             <?php if($msg){ ?>
                 <p> <?=$msg?> </p>
             <?php }else{ ?>
                 <p> 请在下面填写你要反馈的内容 ，我们将在不久后联系您。</p>
             <?php }?>

            <div class="row">
                <div class="col-lg-5">
                    <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                    <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                    <?= $form->field($model, 'email') ?>

                    <?= $form->field($model, 'subject') ?>

                    <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-sm-6">{input}</div><div class="col-sm-3">{image}</div></div>',
                    ]) ?>

                    <div class="form-group">
                        <?= Html::submitButton('提交', ['class' => 'btn btn-primary', 'name' => 'contact-button']) ?>
                        <a class="btn btn-primary" href="/index/index"> 返回到首页 </a>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>



<?php $this->endBody() ?>

<?php $this->endPage() ?>
