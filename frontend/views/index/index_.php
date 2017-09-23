<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
<style>
    body {  background-color: #2c2e2f }
    .header .container {  padding-left: 0px; padding-right: 0px;  }
    .kit-slideshow {  width: 100%; overflow: hidden}
    #kit-slideshow img{width: 1030px;  height: 532px; }
    .nav li a{ text-align: center}
    .breadcrumb {  background-color: #b62222;  }
    .list-group-item { background-color: #46574d;  border: 1px solid #b2cea8;color: #1e2327  }
    .navbar-default {  background-color: #1e1b1b;  border-color: #1e2327;  }
    .navbar-default .navbar-nav > li > a:hover, .navbar-default .navbar-nav > li > a:focus {
        color: #14F806;
    }
    .navbar-default .navbar-nav > li > a {  color: #F8DC0F; font-size: 16px;  }
    .right-list {
        background-color: #00aa00;
        border: solid 6px #aa963e;
        width: 100%;
        height: 174px;
        margin-bottom: 20px;
        color: #fff;
    }
    .right-list-1{  background-color: #aa5614;color: #fff;  border: solid 6px #aa963e;}
    .right-list-2{  background-color: #3270aa;color: #fff;  border: solid 6px #aa963e;}
    .right-list-title{ height: 1.8em ;margin: 0 10px 10px 10px; padding: 20px 10px}
    .right-list-title h2{
        font-size: 1.4em; font-weight: 600;
        float: left; margin: 0px; padding: 0px;
    }
    .right-list-title a{
        float: right;
    }
    .right-list ul li ins{ background-color: transparent ; font-size: 0.9em}
    .right-list a{color: #cffbff  }
    .right-list ul{ padding: 0px 20px; }
    .right-list ul li{  height: 20px; overflow: hidden; margin-left: 14px; line-height: 1.5em}
    .right-list ul li ins{ float: right;}

    .more{ font-size: 0.8em ; float: right}

    a {  color: #f6fc00;  }

</style>
<script>
    var recommendArticles = <?php echo json_encode($recommendArticles);?>;
    var articleCategorys  = <?php echo json_encode($articleCategorys);?>;
    var lastArticle        = <?php echo json_encode($lastArticle)?>;
</script>

<div class="row">
   <!-- 轮播 -->
   <div class="kit-slideshow">
       <div id="kit-slideshow">
           <img src="/images/slide/1.jpg"   alt="活动1">
           <img src="/images/slide/2.jpg"   alt="活动2">
           <img src="/images/slide/3.jpg"   alt="注册">
           <img src="/images/slide/4.jpg"   alt="特色1">
           <img src="/images/slide/5.jpg"   alt="特色2">
           <img src="/images/slide/6.jpg"   alt="特色3">
           <img src="/images/page_1.png"    alt="特色4">
       </div>
       <!-- 控制面板 -->
       <div class="kit-navi" style="display: none">
           <a id="kit-navi-prev" href="#"></a>
           <span id="kit-title"></span>
           <a id="kit-navi-next" href="#"></a>
       </div>
   </div>
</div>
<div class="container">
   <div class="row navbar navbar-default">
       <ul class="nav navbar-nav col-sm-12">
           <?php foreach ($bookLvl1Category as $row){  ?>
               <li class="col-xs-2"><a  href="/index/book?category=<?=$row['id']?>"><?=$row['name']?></a></li>
           <?php } ?>
       </ul>
   </div>

   <div class="row">
       <!--右侧公告栏-->
       <div class="col-md-3 col-md-push-9" style="padding-left: 4px;padding-right: 4px">
           <div class="right-list">
               <div class="right-list-title">
                   <h2>最新公告</h2><a href="" target="_blank">更多&gt;&gt;</a>
               </div>
               <ul>
                   <?php  foreach ($lastNotification as $notification ) { ?>
                       <li><ins><?=$notification['date']?></ins><a target="_blank" title="<?=$notification['title']?>" href="/index/notification?id=<?=$notification['id']?>"><?=$notification['title']?> </a></li>
                   <?php }?>
               </ul>
           </div>
           <div class="right-list right-list-1">
               <div class="right-list-title">
                   <h2>最新文章</h2><a href="" target="_blank">更多&gt;&gt;</a>
               </div>
               <ul>
                   <?php  foreach ($lastArticle as $item ) { ?>
                       <li><a target="_blank" title="<?=$item['title']?>" href="/index/article-detail?id=<?=$item['id']?>"><?=$item['title']?> </a></li>
                   <?php }?>
               </ul>
           </div>

       </div>
       <!--左侧主分类-->
       <div class="col-md-9 col-md-pull-3 row" style="padding-left: 4px;padding-right: 4px">
        <?php
           foreach ($lvl2CategoryAndBooks  as $lvl1Category )
           {
            if(!isset($lvl1Category['id'])) continue;
            $lvl1Title = $lvl1Category['title'];
            $lvl1Id    = $lvl1Category['id'];
            $lvl2s = $lvl1Category['children'];
             foreach ($lvl2s as $lvl2Category)
             {
                 $lvl2Title = $lvl2Category['title'];
                 $lvl2Id    = $lvl2Category['id'];
                 $books = $lvl2Category['children'];
        ?>
            <div class="col-md-6 " >
                <ol class="breadcrumb">
                    <li><a href="/index/book?category=<?=$lvl1Id?>"><?=$lvl1Title?></a></li>
                    <li><a href="/index/book?category=<?=$lvl2Id?>"><?=$lvl2Title?></a></li>
                    <a href="/index/book?category=<?=$lvl2Id?>" class="more">更多</a>
                </ol>
                <ul class="list-group">
                    <?php  foreach ($books  as $book){ ?>
                    <li class="list-group-item"> <a href="/index/book-detail?id=<?=$book['id']?>"><?=$book['title']?></a>  <span class="badge">书</span></li>
                    <?php }?>
                </ul>
            </div>
        <?php } }  ?>


       </div>
   </div>
</div>


<script type='text/javascript' src='/js/lib/scroll/jquery.carouFredSel.min.js'></script>
<script type="text/javascript" src="/js/lib/layer/layer.js"></script>
<script type="text/javascript" src= '/js/common/common.js'></script>
<script type="text/javascript" src= '/js/api.js'></script>
<script type="text/javascript" src="/js/index.js"></script>




