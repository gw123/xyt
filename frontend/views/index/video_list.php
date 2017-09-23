<?php
use common\models\CategorySearch;
use yii\helpers\Html;
//use yii\widgets\LinkPager;
//use yii\data\Pagination;
?>

<link  type="text/css" href="/css/index-list.css" rel="stylesheet">
<link  type="text/css" href="/css/pagination.css" rel="stylesheet">
<script src="/js/lib/pagination/jquery.jqpagination.min.js"></script>

<style>

    .module-title     { line-height: 30px; color: #c88d27 ; margin-bottom: 10px;font-size: 24px; font-weight: 600 }
    .module-title span{ font-size: 14px; font-weight: 500}

    .navbar-panel { line-height: 30px; background-color: #1e1b1b;  border-color: #1e2327; padding:10px 20px; margin-bottom: 10px; }
    .navbar-panel .navbar-nav > li > a:hover, .navbar-panel .navbar-nav > li > a:focus {  color: #14F806;  }
    .navbar-panel .navbar-nav > li > a {  color: #F8DC0F; font-size: 16px; font-weight: 600  }

    .row-list { margin-left: 20px; font-size: 13px ;}

    .current-category{ margin-bottom: 8px; }
    .autumn-grid .course-picture{ height: 240px; overflow: hidden}
    .autumn-grid .course-picture image{max-height: 100%}
    .autumn-course-grid .course-about {
        height: 124px;
    }

</style>


<div class="container">
    <div class="row" style="margin-bottom: 15px;margin-top: 10px;">
        <div class="col-xs-6 col-sm-8">
            <h3 class=" " style="color: #c88d27;">视频列表</h3>
        </div>
        <div class="col-xs-6 col-sm-4" style="text-align: right">
            <?=Html::beginForm('/index/video','get')?>
            <div class="input-group">
                <?=Html::input('text','keyword',Yii::$app->request->get('keyword'),['class'=>'form-control']) ?>
                <span class="input-group-btn">
                   <button class="btn btn-default" type="submit">搜索</button>
                 </span>
            </div>
            <?=Html::endForm()?>
        </div>
    </div>
    <h3 class="module-title row"><div class="col-sm-12">文章分类</div></h3>
    <!-- 导航-->
    <?= \frontend\widgets\CategoryTreeNavWidget::widget(['categoryTree'=>$categoryTree,'url'=>'']) ?>
    <!-- 轮播-->
    <div class="imageDisplay clearfix">
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
        </div>

    </div>
    <div style="clear: both"></div>
    <!-- 当前-->
    <div class="current-category" >
        <label style="font-size: 1.1em">当前目录:</label>
        <?php /**当前目录**/
        //if($currentCategorys) echo "全部";
        foreach ( $currentCategorys  as $category)
            echo "<a href='?category={$category['id']}'> {$category['name']} </a> ";
        ?>
    </div>
    <!-- 列表-->

    <ul id="lesson_list" class="row-list-box2  clearfix">
        <?php
        foreach ($lists as $item) {?>
            <li class=" col-sm-4 col-xs-12 col-md-3">

                <div class="li-box">
                    <h5 class="item-name" title="<?=$item['title']?>">
                        <a href="<?='/index/video-detail?id='.$item['id']  ?>"> <?=$item['title']?> </a>
                    </h5>
                    <div class="item-about" title="<?=$item['desc']?>">
                        <a href="<?='/index/video-detail?id='.$item['id']  ?>">  <?=$item['desc']?> </a>
                    </div>

                    <div class="item-footer">
                        <?php
                        $categorys =  CategorySearch::getTitlesByIdstr($item['category']);
                        foreach ($categorys as $id=>$title)
                        { echo "<a class='price' href='?category={$id}'>{$title} </a>";}
                        ?>
                        <br>
                        <span class="teachers">
                            编辑:<a class="link-dark text-muted" href="/user/index?uid=<?=$item['userId']?>"> <?=isset($item['nickname'])?$item['nickname']:''?> </a>
                           </span>
                    </div>
                </div>

                <img src="<?=$item['cover']? $item['cover'] :Yii::$app->params['CourseDefaultImage']; ?>" alt="" class="img-responsive">
            </li>
        <?php } ?>
    </ul>

    <!-- 翻页-->
    <div class="gigantic pagination">
        <a href="#" class="first" data-action="first">&laquo;</a>
        <a href="#" class="previous" data-action="previous">&lsaquo;</a>
        <input type="text" readonly />
        <a href="#" class="next" data-action="next">&rsaquo;</a>
        <a href="#" class="last" data-action="last">&raquo;</a>
    </div>
</div>
<script type="text/javascript">

    $('.row-list-body li').mouseenter(function(e) {
        $(this).find('img').animate({  left:'0', top:'0', width:'15' ,height:'240px'}, 300);
    }).mouseleave(function(e) {
        $(this).find('img').animate({ left: '0', top: '0', width:'95%',height:'240px'}, 300);
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
<script>
    function getQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
        var r = window.location.search.substr(1).match(reg);
        if (r != null) return unescape(r[2]); return null;
    }

    var current =  getQueryString('page')
    if(!current) current=1;
    var max_page = <?=$totalPage?>;

    $('.pagination').jqPagination({
        link_string	: '/?page1={page_number}',
        current_page  : current,
        max_page	: max_page,
        paged		: function(page) {
            if( window.location.search.match(/page=\d+/) )
                href = window.location.search.replace(/page=\d+/,'page='+page)
            else if( window.location.search=='' )
                href = "?page="+page
            else
                href = window.location.search+"&" +"page="+page

            window.location.href = href
            //$('.log').prepend('<li>Requested page ' + page + '</li>');
        }
    });

    $('#lesson_list li').mouseenter(function(e) {
        $(this).find('img').animate({  left:'0', top:'0', width:'15' ,height:'280px'}, 300);

    }).mouseleave(function(e) {
        $(this).find('img').animate({ left: '0', top: '0', width:'95%',height:'280px'}, 300);
    });

</script>