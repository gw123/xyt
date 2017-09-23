<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$this->title? $this->title:'校园通'?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/common/common.js"></script>
</head>
<body>

<script>
    var _csrf_token ="<?= Yii::$app->request->csrfToken?>" ;
</script>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="navbar-header-index">
                <a class="navbar-brand-logo" href="/"> <img src="/images/logoPK_2x1.png"> </a>
                <ul class="nav navbar-nav">
                        <li class=""><a href="/index/index" class="">首页 </a></li>
                        <li class=""><a href="/index/book" class="">书籍列表 </a></li>
                        <li class=""> <a href="/index/article-list" class="">文章列表 </a></li>
                        <li class=""><a href="/index/video" class="">视频列表 </a></li>
                        <li class=""><a href="/index/material" class="">资料列表 </a></li>
                        <li class=""> <a href="/site/contact" class="">联系我们 </a></li>
                        <li class="">
                            <?php if (Yii::$app->user->isGuest){?>
                                <a href="/site/login" hidefocus="true" style="outline: medium none;">登陆注册</a>
                            <? }else{?>
                                <a href="/user/index" hidefocus="true" style="outline: medium none;">个人中心</a>
                            <?php }?>
                        </li>
                    </ul>
            </div>
        </div>
    </div>
</div>
<div id="middle">
        <?= $content ?>
</div>


<!-- 布局文件这里不能发到结尾 可能有异常发送-->
<!--<script type="application/javascript" src="/js/jquery-2.1.4.js"></script>-->
<!--<script type="text/javascript" src="/js/lib/layer/layer.js"></script>-->
<!--<script type="text/javascript" src= '/js/common/common.js'></script>-->
<!--<script type="text/javascript" src= '/js/api.js'></script>-->
<!--<script type="text/javascript" src="/js/index.js"></script>-->
</body>
</html>



