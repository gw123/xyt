<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$this->title? $this->title:'校园通'?></title>
    <meta name="keywords" content="校园通,计算机技能学习,编程，学习交流，在线学习，在线书籍" />
    <meta name="description" content="免费共享式学习网站，从视频，文章，资料等各个角度学习一个技能。" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?= Html::csrfMetaTags() ?>
    <link  type="text/css" href="/css/index.css" rel="stylesheet">
    <link  type="text/css" href="/css/screen.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/common.css">

    <script type="application/javascript" src="/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="/js/lib/layer/layer.js"></script>
    <script type="text/javascript" src= '/js/common/common.js'></script>
    <script type="text/javascript" src= '/js/api.js'></script>
</head>
<body>

<script>
    var _csrf_token ="<?= Yii::$app->request->csrfToken?>" ;
</script>
<div class="body_wrap">
    <div class="header">
        <div class="center">
            <div class="logo">
                <a href="/index/index"><img src="/images/logoPK_2x1.png" alt="17ky" border="0"></a>
            </div>
            <div class=" topmenu topmenu_left">
                <ul id="menu-menu_left" class="dropdown">
                    <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-348">
                        <a href="/index/book" hidefocus="true" style="outline: medium none;"><span>教材列表</span></a>
                    </li>
                    <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-409">
                        <a href="/index/article" hidefocus="true" style="outline: medium none;"><span>文章列表</span></a>
                    </li>
                </ul>
            </div>
            <div class="topmenu topmenu_right>">
                <ul id="menu-menu_right" class="dropdown">
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-348">
                        <a href="/index/video" hidefocus="true" style="outline: medium none;"><span>视频列表</span></a>
                    </li>
                    <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-409">
                        <a href="/index/material" hidefocus="true" style="outline: medium none;"><span>资源列表</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="middle">
        <div class="container ">
            <?= $content ?>
        </div>
    </div>
</div>
<div class="divider"></div>
</div>
<!-- 布局文件这里不能发到结尾 可能有异常发送-->
<!--<script type="application/javascript" src="/js/jquery-2.1.4.js"></script>-->
<!--<script type="text/javascript" src="/js/lib/layer/layer.js"></script>-->
<!--<script type="text/javascript" src= '/js/common/common.js'></script>-->
<!--<script type="text/javascript" src= '/js/api.js'></script>-->
<!--<script type="text/javascript" src="/js/index.js"></script>-->
</body>
</html>



