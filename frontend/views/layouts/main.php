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
    <link  type="text/css" href="/css/common.css" rel="stylesheet">
    <script type="application/javascript" src="/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="/js/lib/layer/layer.js"></script>
    <script type="application/javascript" src="/js/common/common.js"></script>
    <script type="application/javascript" src="/js/api.js"></script>

</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '用户中心',
        'brandUrl' => Yii::$app->homeUrl,
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
                'label' => '我的书籍',
                'items' => [
                    ['label' => '我的笔记', 'url' => ['/user/index']],
                    ['label' => '共享笔记', 'url' => ['/sys/menu']],
                    ],
            ];

            $menuItems[] = [
                'label' => '我的文章',
                'items' => [
                    ['label' => '我的文章', 'url' => ['/systask/index']],
                    ['label' => '收藏文章', 'url' => ['/systask-tpl/index']],
                    ['label' => '草稿', 'url' => ['/caiji/index']],
                ],
            ];
        }

        $menuItems[] = [
            'label' => '我的课程',
            'items' => [
                ['label' => '目录', 'url' => ['/category/index']],
                ['label' => '学校', 'url' => ['/school/index']],
                ['label' => '章节', 'url' => ['/chapter/index']],

            ],
        ];
        $menuItems[] = [
            'label' => '兴趣小组',
            'items' => [
                ['label' => '创建小组', 'url' => ['/point/index']],
                ['label' => '加入小组', 'url' => ['/course/index']],
            ],
        ];

        $menuItems[] = [
            'label' => '关注/粉丝',
            'items' => [
                ['label' => '创建小组', 'url' => ['/point/index']],
                ['label' => '加入小组', 'url' => ['/course/index']],
            ],
        ];

        $menuItems[] = [
            'label' => '个人设置',
            'items' => [
                ['label' => '创建小组', 'url' => ['/point/index']],
                ['label' => '加入小组', 'url' => ['/course/index']],
            ],
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

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 17ky  <?= date('Y') ?></p>

        <p class="pull-right"> 17禁地 </p>
    </div>
</footer>

<?php $this->endBody() ?>
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/addKityFormulaDialog.js"></script>-->
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/getKfContent.js"></script>-->
<!--<script type="text/javascript" charset="utf-8" src="/js/lib/ue/kityformula-plugin/defaultFilterFix.js"></script>-->
</body>
</html>
<?php $this->endPage() ?>
