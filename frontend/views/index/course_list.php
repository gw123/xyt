<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>课程列表</title>
    <link  type="text/css" href="/css/index-course.css" rel="stylesheet">
    <link  type="text/css" href="/css/screen.css" rel="stylesheet">
</head>
<body>
<script>

</script>
<div class="body_wrap">
   <div class="header">
       <div class="container">
           <div class="logo">
               <img src="/images/logoPK_2x1.png" alt="17ky" border="0">
           </div>
           <div class=" topmenu topmenu_left">
               <ul id="menu-menu_left" class="dropdown">
                   <li  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-348">
                       <a href="/index/book" hidefocus="true" style="outline: medium none;"><span>教材列表</span></a>
                   </li>
                   <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-409">
                       <a href="/index/course" hidefocus="true" style="outline: medium none;"><span>课程列表</span></a>
                   </li>

               </ul>
           </div>
           <div class="topmenu topmenu_right>">
               <ul id="menu-menu_right" class="dropdown">
                   <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-348">
                       <a href="/index" hidefocus="true" style="outline: medium none;"><span>首页</span></a>
                   </li>
                   <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-409">
                       <a href="" hidefocus="true" style="outline: medium none;"><span>联系我们</span></a>
                   </li>
               </ul>
           </div>
       </div>
   </div>

   <div id="middle">
   <div class="container">

       <!-- 课程列表 -->
       <div class="container">
           <div class="module-title clearfix">
               <h1>课程列表</h1>
           </div>

           <div class="row">
               <ul id="lesson_list" class="autumn-grids list-box">
                   <?php
                    foreach ($lists as $item) {?>
                        <li class="autumn-grid autumn-course-grid">
                            <a href="<?= Yii::$app->params['EduHost'].'/course/'.$item['id']  ?>" class="course-picture">
                                <img src="<?=$item['cover']? $item['cover'] :Yii::$app->params['CourseDefaultImage']; ?>" alt="" class="img-responsive">
                                  <div class="course-label"> </div>
                            </a>
                            <div class="course-body">
                                <h3 class="course-name"><a href="/course/4"><?=$item['title']?></a></h3>
                                <div class="course-about"> <?=$item['desc']?>  </div>
                                <div class="course-price-info">
                                        <span class="course-price-widget">
                                        <span class="price"> 免费</span></span>
                                </div>
                                <div class="course-metas">
                                    <span class="teachers">
                                     主讲:<a class="link-dark text-muted" href="#"><?= \common\models\User::getNickNameById($item['userId'])?></a>
                                    </span>
                                </div>
                            </div>
                        </li>
                   <?php } ?>
               </ul>
           </div>

       </div>
       <div class="clear"></div>
   </div>
   </div>
</div>
<div class="divider"></div>
</div>
<script type="application/javascript" src="/js/jquery-2.1.4.js"></script>
<script type='text/javascript' src='/js/lib/scroll/jquery.carouFredSel.min.js'></script>
<script type="text/javascript" src="/js/lib/layer/layer.js"></script>
<script type="text/javascript" src= '/js/common/common.js'></script>
<script type="text/javascript" src= '/js/api.js'></script>
<script type="text/javascript" src="/js/index.js"></script>
</body>
</html>



