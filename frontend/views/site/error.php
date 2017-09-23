<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title> <?=$name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="/home/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/home/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="/home/css/font-awesome-ie7.min.css" />
    <![endif]-->
    <!-- page specific plugin styles -->
    <!-- fonts -->
    <link rel="stylesheet" href="http://fonts.lug.ustc.edu.cn/css?family=Open+Sans:400,300" />
    <!-- ace styles -->
    <link rel="stylesheet" href="/home/css/ace.min.css" />
    <link rel="stylesheet" href="/home/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="/home/css/ace-skins.min.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/home/css/ace-ie.min.css" />
    <![endif]-->
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/home/js/html5shiv.js"></script>
    <script src="/home/js/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-color: #fff">

<div class="page-content">
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->

            <div class="error-container">
                <div class="well">
                    <h1 class="grey lighter smaller">
                        <span class="blue bigger-125">
                            <i class="icon-random"></i>
                            <?=$name?>
                        </span>
                       <h2 style="text-align: center;"> <?=$message ?></h2>
                    </h1>

                    <hr />
                    <h3 class="lighter smaller">
                        工程师正在修复
                        <i class="icon-wrench icon-animated-wrench bigger-125"></i>
                        这个问题
                    </h3>

                    <div class="space"></div>

                    <div>
                        <h4 class="lighter smaller"> 您可以，感谢您使用我们的系统。</h4>

                        <ul class="list-unstyled spaced inline bigger-110 margin-15">
                            <li>
                                <a href="/site/contact"><i class="icon-hand-right blue"></i>联系我们 </a>
                            </li>
                        </ul>
                    </div>

                    <hr />
                    <div class="space"></div>

                    <div class="center">
                        <a href="#" class="btn btn-grey" onclick="window.history.go(-1)">
                            <i class="icon-arrow-left"></i>
                            返回上一页
                        </a>

                        <a href="/index/index" class="btn btn-primary">
                            <i class="icon-dashboard"></i>
                            返回网站首页
                        </a>
                    </div>
                </div>
            </div>

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

</body>
</html>
