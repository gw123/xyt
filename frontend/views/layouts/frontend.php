<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <script type="application/javascript" src="/js/api.js"></script>
    <link  type="text/css" href="/css/index.css" rel="stylesheet">
    <link  type="text/css" href="/css/screen.css" rel="stylesheet">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '首页',
        'brandUrl' => "/index",
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        // ['label' => 'Home', 'url' => ['/site/index']],
        //['label' => 'About', 'url' => ['/site/about']],
        //['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $roles =Yii::$app->authManager->getRolesByUser(Yii::$app->user->id);
        if(isset($roles['superAdmin']))
        {
            $menuItems[] = [
                'label' => '课程中心',
                'url' => ['/index/course']
            ];

            $menuItems[] = [
                'label' => '教材中心',
                'url' => ['/index/book']
            ];
        }

        $menuItems[] = [
            'label' => '讨论组',
            'url' => ['/index/group']
        ];


        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<!--<footer class="footer">-->
<!---->
<!--</footer>-->
<div class="divider"></div>

<?php $this->endBody() ?>
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/addKityFormulaDialog.js"></script>-->
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/getKfContent.js"></script>-->
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/defaultFilterFix.js"></script>-->
</body>
</html>
<?php $this->endPage() ?>
