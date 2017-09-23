<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>知我书屋</title>
    <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/common.css">
    <link rel="stylesheet" href="/css/index-index.css">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/js/common/common.js"></script>
    <script src="/js/index.js"></script>
</head>
<body>
<div class="header clearfix">
    <div class="center ">
        <div class="topmenu ">
            <a href="/index/book" hidefocus="true" style="outline: medium none;">书籍列表</a>
            <a href="/index/article-list" hidefocus="true" style="outline: medium none;">文章列表</a>
            <a href="/index/video" hidefocus="true" style="outline: medium none;">视频列表</a>
        </div>
        <div class="logo"><a href="/index/index"> <img src="/images/logoPK_2x1.png"> </a></div>
        <div class="topmenu ">
            <a href="/index/material" hidefocus="true" style="outline: medium none;">资料列表</a>
            <a href="/site/contact" hidefocus="true" style="outline: medium none;">联系我们</a>
            <?php if (Yii::$app->user->isGuest){?>
                <a href="/site/login" hidefocus="true" style="outline: medium none;">登陆注册</a>
            <? }else{?>
                <a href="/user/index" hidefocus="true" style="outline: medium none;">个人中心</a>
            <?php }?>
        </div>
    </div>
</div>

<!--导航 Start-->
<div class="menu">
    <div class="all-sort clearfix"><span><a href="/index/index?ctype=10">技术分类</a><a href="/index/index?ctype=1">学科分类</a></span></div>
    <div class="ad"></div>
    <!-- 分享这个网站-->
    <div class="share">
        <!-- JiaThis Button BEGIN -->
        <div class="jiathis_style_32x32">
            <a class="jiathis_button_qzone"></a>
            <a class="jiathis_button_tsina"></a>
            <a class="jiathis_button_tqq"></a>
            <a class="jiathis_button_weixin"></a>
            <a class="jiathis_button_renren"></a>
        </div>
        <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
        <!-- JiaThis Button END -->
    </div>
    <div class="nav">
        <ul class="clearfix">
            <li><a href="/index/book">web开发</a></li>
            <li><a href="/index/book">游戏开发</a></li>
            <li><a href="/index/book">移动开发</a></li>
            <li><a href="/index/book">嵌入式开发</a></li>
            <li><a href="/index/book">人工智能</a></li>
            <li><a href="/index/book">大数据</a></li>
        </ul>
    </div>
</div>
<!--导航 End-->

<div class="wrap">
    <div class="clearfix">
        <!--所有分类 Start-->
        <div class="all-sort-list">
            <?php  foreach ($categoryTree as $category){ ?>
            <div class="item">
                <h3><span>·</span><a href=""><a href="/index/book?id=<?$category['id']?>"><?=$category['title']?></a></h3>
                <div class="item-list clearfix">
                    <div class="close">x</div>
                    <?php  if(isset($category['children'])) foreach ($category['children'] as $son){ ?>
                        <div class="subitem">
                            <dl class="fore1">
                                <dt><a href="/index/book?id=<?$son['id']?>"><?=$son['title']?></a></dt>
                                <dd>
                                    <?php  if(isset($son['children'])) foreach ($son['children'] as $grandson){ ?>
                                        <em><a href="/index/book?id=<?$grandson['id']?>"><?=$grandson['title']?></a></em>
                                    <?php }?>
                                </dd>
                            </dl>
                        </div>
                    <?php }?>
                    <div class="cat-right">
                        <dl class="categorys-promotions" clstag="homepage|keycount|home2013|0601c">
                            <dd>
                                <ul>
                                    <li><a href="#"><img src="/images/default.jpg" width="194" height="70" style="margin-bottom: 10px;" ></a></li>
                                    <li><a href="#"><img src="/images/default.jpg" width="194" height="70" ></a></li>
                                </ul>
                            </dd>
                        </dl>
                        <dl class="categorys-brands" clstag="homepage">
                            <dt>推荐</dt>
                            <dd>
                                <ul>
                                    <li><a href="/index/book">移动开发</a></li>
                                    <li><a href="/index/book">嵌入式开发</a></li>
                                    <li><a href="/index/book">人工智能</a></li>
                                    <li><a href="/index/book">大数据</a></li>
                                </ul>
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
        <!-- 轮播-->
        <div class="imageDisplay">
            <div id="myCarousel" class="carousel slide">
                <!-- 轮播（Carousel）指标 -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                </ol>
                <!-- 轮播（Carousel）项目 -->
                <div class="carousel-inner">
                    <div class="item active">
                        <img src="/images/slide/1.jpg" alt="First slide">
                    </div>
                    <div class="item">
                        <img src="/images/slide/2.jpg" alt="Second slide">
                    </div>
                    <div class="item">
                        <img src="/images/slide/3.jpg" alt="Third slide">
                    </div>
                </div>
                <!-- 轮播（Carousel）导航 -->
                <a class="carousel-control left"  href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
            </div>

        </div>
        <!--通知 Start-->
        <div class="notifyDisplay">
            <h4> 通知活动栏 </h4>
            <ol>
                <?php foreach ($notifications as $notification) {?>
                    <li>  <a href="/index/notification?id=<?=$notification['id']?>"> <?=$notification['title']?> </a> </li>
                <?php }?>
            </ol>
        </div>
    </div>


    <div class="row-list-box clearfix">
        <div class="row-list-header clearfix">
            <span> 最新书籍 </span>
            <div class="en"> <div>New Book </div><div><a href="/index/book"> 查看更多&gt;&gt;</a> </div> </div>
        </div>
        <div class="row-list-body">
            <ul  class="autumn-grids list-box">
                <?php foreach ($lastBooks as $row) {?>
                <li>
                    <div class="item-body">
                        <a href="/index/book-detail?bookId=<?=$row['id']?>">  <h3 class="item-name" ><?=$row['title']?></h3> </a>
                        <div class="item-about"><?=$row['desc']?></div>

                        <div class="item-metas">
                            <span class="user">
                              编辑:<a class="link-dark text-muted" href="/user/index?id=<?=$row['userId']?>"> <?=$row['nickname']?> </a>
                            </span>
                            <div class="time"><?=$row['createdTime']?></div>
                        </div>
                    </div>
                    <img src="<?=$row['cover']?$row['cover']:Yii::$app->params['defaultImage']?>" alt="" class="img-responsive">
                </li>
                <?php }?>
            </ul>
        </div>
    </div>
    <div class="row-list-box clearfix">
        <div class="row-list-header clearfix">
            <span> 最新视频 </span>
            <div class="en"> <div>New Video </div><div><a href="/index/video"> 查看更多&gt;&gt;</a> </div> </div>
        </div>
        <div style="clear: both"></div>
        <div class="row-list-body">
            <ul  class="autumn-grids list-box">
                <?php foreach ($lastVideos as $row) {?>
                    <li>
                        <div class="item-body">
                            <a href="/index/video-detail?id=<?=$row['id']?>">  <h3 class="item-name" ><?=$row['title']?></h3> </a>
                            <div class="item-about"><?=$row['desc']?></div>

                            <div class="item-metas">
                            <span class="user">
                              编辑:<a class="link-dark text-muted" href="/user/index?id=<?=$row['userId']?>"> <?=$row['nickname']?> </a>
                            </span>
                                <div class="time"><?=$row['createdTime']?></div>
                            </div>
                        </div>
                        <img src="<?=$row['cover']?$row['cover']:Yii::$app->params['defaultImage']?>" alt="" class="img-responsive">
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>
    <div class="row-list-box clearfix">
        <div class="row-list-header clearfix">
            <span> 最新资料 </span>
            <div class="en"> <div>New Material </div><div><a href="/index/material"> 查看更多&gt;&gt;</a> </div> </div>
        </div>
        <div style="clear: both"></div>
        <div class="row-list-body">
            <ul  class="autumn-grids list-box">
                <?php foreach ($lastMaterials as $row) {?>
                    <li>
                        <div class="item-body">
                            <a href="/index/material-detail?id=<?=$row['id']?>">  <h3 class="item-name" ><?=$row['title']?></h3> </a>
                            <div class="item-about"><?=$row['desc']?></div>

                            <div class="item-metas">
                            <span class="user">
                              编辑:<a class="link-dark text-muted" href="/user/index?id=<?=$row['userId']?>"> <?=$row['nickname']?> </a>
                            </span>
                                <div class="time"><?=$row['createdTime']?></div>
                            </div>
                        </div>
                        <img src="<?=$row['cover']?$row['cover']:Yii::$app->params['defaultImage']?>" alt="" class="img-responsive">
                    </li>
                <?php }?>
            </ul>
        </div>
    </div>

    <script>
        var recommendArticles = <?php echo json_encode($recommendArticles);?>;
        var articleCategorys  = <?php echo json_encode($articleCategorys);?>;
        var hotArticle         = <?php echo json_encode($hotArticle)?>;
        var lastArticle        = <?php echo json_encode($lastArticle)?>;
    </script>
    <div style="height: 25px"></div>
    <!-- 文章列表 -->
    <div class="row">
        <div class="col-md-8 col-xs-12 clearfix">
            <!-- 文章导航 -->
            <div class="middle-left-nav article-categorys">
                <a href="javascript:;" class="article-category" id="0">综合</a>
                <?php
                foreach ($articleCategorys as $category)
                { echo "<a href='javascript:;' id='{$category['id']}' class='article-category'>{$category['title']}</a> "; }
                ?>
                </span>
            </div>
            <!-- 主分类列表   置顶帖子 -->
            <div class="middle-left-list main-article-list" style="display:block">
            <ul>
                <li>
                    <div class="pic"><a href="" target="_blank">
                            <img src="/images/default.png"></a>
                        <p><a href="" target="_blank">系统</a></p>
                    </div>
                    <div class="rinfo">
                        <a href="" target="_blank">{title}</a> <i class="date">{createdTime}</i>
                        <p>{desc}</p>

                        <div class="chapter">

                            <span>
                            <a href="" target="_blank" class="tag">{chapter} </a>
                            <a href="" target="_blank" class="tag">{chapter}</a>
                           </span>
                        </div>

                    </div>
                </li>
                <li>
                    <div class="pic"><a href="" target="_blank">
                            <img src="/images/default.png"></a>
                        <p><a href="" target="_blank">系统</a></p>
                    </div>
                    <div class="rinfo">
                        <a href="" target="_blank">{title}</a>
                        <p>{desc}</p>
                        <div class="time">
                            <i>{createdTime}</i>
                            <span>
                            <a href="" target="_blank" class="tag">{chapter} </a>
                            <a href="" target="_blank" class="tag">{chapter}</a>
                           </span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="pic"><a href="" target="_blank">
                            <img src="/images/default.png"></a>
                        <p><a href="" target="_blank">系统</a></p>
                    </div>
                    <div class="rinfo">
                        <a href="" target="_blank">{title}</a>
                        <p>{desc}</p>
                        <div class="time">
                            <i>{createdTime}</i>
                            <span>
                            <a href="" target="_blank" class="tag">{chapter} </a>
                            <a href="" target="_blank" class="tag">{chapter}</a>
                           </span>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="pic"><a href="" target="_blank">
                            <img src="/images/default.png"></a>
                        <p><a href="" target="_blank">系统</a></p>
                    </div>
                    <div class="rinfo">
                        <a href="" target="_blank">{title}</a>
                        <p>{desc}</p>
                        <div class="time">
                            <i>{createdTime}</i>
                            <span>
                            <a href="" target="_blank" class="tag">{chapter} </a>
                            <a href="" target="_blank" class="tag">{chapter}</a>
                           </span>
                        </div>
                    </div>
                </li>
            </ul>
            </div>
        </div>
        <div class="col-md-4 col-xs-12 clearfix">
            <!-- 排行列表 -->
            <div class="home-right fl mt10">
                <div class="rbor rtopline fl article-last">
                    <div class="rtit">最新发布<a class="change" href="javascript:;"></a></div>
                    <div class="zd-list">
                        <ul>
                            <li><a href="#" target="_blank"><i class="tcolor">原创 | </i></a><a href="#" title="" target="_blank"><span>{1}</span></a></li>
                            <li><a href="#" target="_blank"><i class="tcolor">专栏 | </i></a><a href="#" title="" target="_blank"><span>58沈剑：数据库秒级平滑扩容架构方案</span></a></li>
                            <li><a href="#" target="_blank"><i class="tcolor">译文 | </i></a><a href="#" title="" target="_blank"><span>初创企业为什么倾向于选择Swift而非Objective-C？</span></a></li>
                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>

                <div class="rbor rtopline fl mt15 article-hot">
                    <div class="rtit">一周排行</div>
                    <div class="ph-list">
                        <ul>
                            <li class="line">
                                <span class="redbg">1</span>
                                <div class="rinfo1">
                                    <a href="" target="_blank" title="移动安全小技巧：" style="display:block; overflow:hidden; height:22px; line-height:22px;">移动安全小技巧：如何放心将您的Android</a>
                                    <p>不少简单方法能够帮助我们自信地把手机借给朋友<a href="" target="_blank" title="移动安全小技巧：">&nbsp;&nbsp;[详细]</a></p>
                                </div>
                            </li>

                            <li>
                                <span class="redbg">2</span>
                                <div class="rinfo">
                                    <a href="" target="_blank" title="Linux下的十项实用“sudo”配置选项">Linux下的十项实用“sudo”配置选项</a>
                                </div>
                            </li>

                            <li>
                                <span class="redbg">3</span>
                                <div class="rinfo">
                                    <a href="http://network.51cto.com/art/201702/530143.htm" target="_blank" title="边缘计算重新定义企业基础设施 新三层架构更灵活">边缘计算重新定义企业基础设施 新三层架</a>
                                </div>
                            </li>

                            <li>
                                <span class="redbg">4</span>
                                <div class="rinfo">
                                    <a href="http://news.51cto.com/art/201702/530004.htm" target="_blank" title="暗网也被“黑吃黑”  匿名黑客21个步骤拿下20%暗网">暗网也被“黑吃黑”  匿名黑客21个步骤拿</a>
                                </div>
                            </li>

                            <li>
                                <span class="redbg">5</span>
                                <div class="rinfo">
                                    <a href="http://developer.51cto.com/art/201702/530011.htm" target="_blank" title="为什么你该开始学习编程了？">为什么你该开始学习编程了？</a>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="clear"></div>
                </div>

            </div>
        </div>
    </div>


</div>



<!--所有分类 End-->
<script type="text/javascript" src="/js/jquery-2.1.4.js"></script>
<script type="text/javascript">

    $('.row-list-body li').mouseenter(function(e) {
        $(this).find('img').animate({  left:'0', top:'0', width:'15' ,height:'260px'}, 300);
    }).mouseleave(function(e) {
        $(this).find('img').animate({ left: '0', top: '0', width:'100%',height:'260px'}, 300);
    });

    $('.all-sort-list > .item').hover(function(){
        var eq = $('.all-sort-list > .item').index(this),				//获取当前滑过是第几个元素
            h = $('.all-sort-list').offset().top,						//获取当前下拉菜单距离窗口多少像素
            s = $(window).scrollTop(),									//获取游览器滚动了多少高度
            i = $(this).offset().top,									//当前元素滑过距离窗口多少像素
            item = $(this).children('.item-list').height(),				//下拉菜单子类内容容器的高度
            sort = $('.all-sort-list').height();						//父类分类列表容器的高度
        if ( item < sort ){												//如果子类的高度小于父类的高度
            if ( eq == 0 ){
                $(this).children('.item-list').css('top', (i-h));
            } else {
                $(this).children('.item-list').css('top', (i-h)+1);
            }
        } else {
            if ( s > h ) {												//判断子类的显示位置，如果滚动的高度大于所有分类列表容器的高度
                if ( i-s > 0 ){											//则 继续判断当前滑过容器的位置 是否有一半超出窗口一半在窗口内显示的Bug,
                    $(this).children('.item-list').css('top', (s-h)+2 );
                } else {
                    $(this).children('.item-list').css('top', (s-h)-(-(i-s))+2 );
                }
            } else {
                $(this).children('.item-list').css('top', 3 );
            }
        }
        $(this).addClass('hover');
        $(this).children('.item-list').css('display','block');
    },function(){
        $(this).removeClass('hover');
        $(this).children('.item-list').css('display','none');
    });
    $('.item > .item-list > .close').click(function(){
        $(this).parent().parent().removeClass('hover');
        $(this).parent().hide();
    });
</script>
</body>
</html>