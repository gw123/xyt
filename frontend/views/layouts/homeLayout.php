<?php
use frontend\assets\AppAsset;
use yii\widgets\Breadcrumbs;
AppAsset::register($this);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>我的空间</title>
    <meta name="keywords" content="校园通" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/home/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/home/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/home/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!-- page specific plugin styles -->
    <!-- fonts -->
    <link rel="stylesheet" href="/home/css/fonts-css.css" />
    <!-- ace styles -->
    <link rel="stylesheet" href="/home/css/ace.min.css" />
    <link rel="stylesheet" href="/home/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/home/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/home/css/ace-ie.min.css" />
    <![endif]-->
    <link rel="stylesheet" href="/css/common.css" />
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->
    <script src="/home/js/ace-extra.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/home/js/html5shiv.js"></script>
    <script src="/home/js/respond.min.js"></script>
    <![endif]-->
    <script src="/home/js/jquery.min.js"></script>
    <script src="/home/js/bootstrap.min.js"></script>
    <script src="/home/js/typeahead-bs2.min.js"></script>
    <!-- page specific plugin scripts -->
    <!--[if lte IE 8]>
    <script src="/home/js/excanvas.min.js"></script>
    <![endif]-->
    <script src="/home/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/home/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/home/js/jquery.slimscroll.min.js"></script>
    <script src="/home/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/home/js/jquery.sparkline.min.js"></script>
    <script src="/home/js/flot/jquery.flot.min.js"></script>
    <script src="/home/js/flot/jquery.flot.pie.min.js"></script>
    <script src="/home/js/flot/jquery.flot.resize.min.js"></script>
    <!-- ace scripts -->
    <script src="/home/js/ace-elements.min.js"></script>
    <script src="/home/js/ace.min.js"></script>
    <link rel="stylesheet" href="/home/css/home.css" />
    <script src="/home/js/bootbox.min.js"></script>

    <script src="/js/lib/layer/layer.js"></script>
    <script src="/js/common/common.js"></script>
    <script src="/js/api.js"></script>
</head>
<body>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        var _csrf_token = '<?= Yii::$app->request->csrfToken   ?>';
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>
    <?= $this->render('homeHeader.php')  ?>
</div>
<div class="main-container" id="main-container">
    <div class="main-container-inner">
        <a class="menu-toggler" id="menu-toggler" href="#">
            <span class="menu-text"></span>
        </a>

        <?= $this->render('homeSidebar.php')  ?>

        <div class="main-content">
            <div class="breadcrumbs" id="breadcrumbs">

                <script type="text/javascript">
                    try{ace.settings.check('main-container' , 'fixed')}catch(e){}
                    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
                </script>

                <ul class="breadcrumb">
                    <li><a href="/index/index"> <i class="icon-home home-icon"></i></a> </li>
                    <?= Breadcrumbs::widget([
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]) ?>

                </ul><!-- .breadcrumb -->

                <div class="nav-search" id="nav-search">
                    <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="icon-search nav-search-icon"></i>
                    </span>
                    </form>
                </div><!-- #nav-search -->
            </div>

            <div class="page-content">
                <div class="page-header" style="display: none">
                    <h1>控制台
                        <small> <i class="icon-double-angle-right"></i>查看 </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <!-- 主区域提示 -->
                        <div class="alert alert-block alert-success" style="display: none">
                            <button type="button" class="close" data-dismiss="alert">
                                <i class="icon-remove"></i>
                            </button>
                            <i class="icon-ok green"></i>
                            欢迎使用
                            <strong class="green"> 小说管理系统</strong>
                        </div>
                        <?= $content ?>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->
        <!--- 设置布局 -->
        <div class="ace-settings-container" id="ace-settings-container" style="display: none">
            <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
                <i class="icon-cog bigger-150"></i>
            </div>
            <div class="ace-settings-box" id="ace-settings-box">
                <div>
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="default" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; 选择皮肤</span>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar" />
                    <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar" />
                    <label class="lbl" for="ace-settings-sidebar"> 固定滑动条</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs" />
                    <label class="lbl" for="ace-settings-breadcrumbs">固定面包屑</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl" />
                    <label class="lbl" for="ace-settings-rtl">切换到左边</label>
                </div>

                <div>
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container" />
                    <label class="lbl" for="ace-settings-add-container">
                        切换窄屏
                        <b></b>
                    </label>
                </div>
            </div>
        </div><!-- /#ace-settings-container -->
    </div><!-- /.main-container-inner -->
</div>
</body>
</html>
