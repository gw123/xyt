<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title> <?=$currentChapter['title']?> </title>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="/js/lib/danmu/jquery-2.1.4.min.js"></script>
    <script src="/js/lib/pdf/build/pdf.js"></script>
    <link  type="text/css" href="/css/index-detal.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/js/lib/tree/css/metroStyle/metroStyle.css" type="text/css">
    <link rel="stylesheet" href="/css/common.css" type="text/css">
    <link rel="stylesheet" href="/js/lib/pet/css/pet.css" type="text/css">
</head>

<script>
    var  rootChapter    = <?=$rootChapter?>;
    var _csrf_token = "<?= Yii::$app->request->csrfToken;?>";
    var  currentChapter = <?php echo json_encode($currentChapter); ?>;
    var  treeMap    = <?php echo json_encode($chapterTree) ?>;
    var  articleList      = <?php echo json_encode($articleList) ?>;

    var  videoList      = <?php echo json_encode($videoList) ?>;
    var  materialList   = <?php echo json_encode($materialList)?>;

    var  pointList      = [];
    var  testpaperList  = [];

    var  eduHost     =  '<?= Yii::$app->params['EduHost']?>';
    var  currentUser = <?php echo json_encode($user)?>;
    var  articleData = <?php echo json_encode($articleData)?>;
    var  videoData = [];
    var  materialData = [];
    var  pointData = [];
    var isindex = true;
    var visitor = currentUser.nickname;
    // 当前 知识点节点
    var currentTreeNode = rootChapter;
    var _currentBookPage =  0;

</script>

<body>
<!--书童-->
<div id="spig" class="spig"  style="display: none">
    <div id="message">正在加载中……</div>
    <div id="mumu" class="mumu"></div>
</div>
<!--书童end*-->
<!-- --->
<header>
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand-logo" href="/"> <img src="/images/default/logo.jpeg"> </a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class=""><a href="/" class="">师资力量 </a></li>
                <li class=""> <a href="/" class="">常见问题 </a></li>
                <li class=""><a href="/" class="">关于我们 </a></li>
                <li class=""><a href="/user/index" class=""> <?=$user['nickname']?></a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li class="hidden-xs hidden-sm hidden-md"><a href="/"> 返回首页 </a></li>

                <li class="hidden-xs hidden-sm li-input">
                    <form class="navbar-form navbar-right" action="/search" method="get">
                        <div class="form-group">
                            <input class="form-control" name="q" placeholder="搜索">
                            <button class="header-button">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </div>
                    </form>
                </li>

                <li class="hidden-xs hidden-sm hidden-md"><a href="/notification" class="badge-container notification-badge-container">
                    <span class="glyphicon glyphicon-bullhorn"></span>
                </a></li>

            </ul>
        </div>
    </div>
</header>

<div  id ="body-wrap" class="body-wrap" >
     <div class="container">
         <!----------------------- 课程描述 ------------------------>
         <div class="lesson_desc">
             <div class="container" style="position: relative">
<!--                 <span class="tip-rt">-->
<!--                   <a id="join_course" _href="/course/join?id=--><?//=$rootChapter?><!--">  --><?php //if($join){ echo"已加入"; }else{ echo "加入课程"; } ?><!-- </a>-->
<!--                 </span>-->
             <div class="row" >

                <div class="col-md-3  col-sm-4 col-xs-5 lesson_left" style="height: 160px">
                    <img src="<?=$currentChapter['cover']?>" style="width:auto; height:auto; max-width:100%;max-height:100%; ">
                </div>
                 <div class="col-md-9 col-sm-8 col-xs-7 lesson_right">
                     <div class="title_"><?=$currentChapter['title']?></div>
                     <div class="info_"> <?=$currentChapter['desc'] ?></div>
<!--                     <div class="mark_"> <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i>-->
<!--                         <i class="glyphicon glyphicon-star"></i> <i class="glyphicon glyphicon-star"></i>-->
<!--                         <i class="glyphicon glyphicon-star-empty"></i>-->
<!--                         (0 评论)-->
<!--                       </div>-->
                 </div>
             </div>
             </div>
         </div>

         <div class="current_pos">
             <lable>当前位置：</lable>
             <span class="current-pos-content" >
                 <?php foreach ($currentChapter['parents'] as $chapter)
                 {  echo "<a href='?id={$chapter['id']}'>{$chapter['title']}</a><small> >> </small>";
                 }?>
             </span>
         </div>
         <!----------------------- 课程描述 voer ------------------------>
         <div class="container">
             <div  id="main_content" class="main_content row">
                 <div class="col-md-12 left_">
                     <div class="row">
                         <div class="left-nav">
                             <ul class="page-nav">
                                 <li data-target="page_chapter_content">内容</li>
                                 <li data-target="page_article_list">文章列表</li>
<!--                                 <li data-target="page_common_list"> 讨论区 </li>-->
                                 <li data-target="page_material_list"> 资料 </li>
                                 <li data-target="page_video_list">视频</li>
                                 <li data-target="page_point_list">知识点</li>
                                 <li data-target="page_exam_list">练习题</li>
                             </ul>
                         </div>

                         <div class="left-conent">

                             <div id="page_chapter_content"   class="left-conent-page">
                                 <div id="chapter_content" style="padding-left: 10px; text-align: center">
<!--                                 <canvas id="page-canvas"></canvas>-->
                                 </div>
                                 <style>
                                      .page-control{
                                          position:  fixed;
                                          width: 200px;
                                          right: 15%;
                                          bottom: 5%;
                                          font-size: 20px;
                                          color: #8cef87;
                                      }
                                     .page-control span{
                                         width: 50%;
                                         cursor: pointer;
                                     }
                                 </style>
                                 <div class="page-control">
                                     <span class="pre-page"> 上一页 </span>  <span class="next-page">下一页</span>
                                 </div>
                             </div>
                             <!--------- 显示文章列表 ---------->
                             <div id="page_article_list"  style="display: none" class="left-conent-page"  >
                                 <h5  class="title">文章列表</h5>
                                 <ul id="article_list" class="box-list">
                                     <li  style="display: none" class="box" data-target="{id}"> {title} </li>
                                 </ul>
                                 <div style="clear: both"></div>
                             </div>
                             <!--------- 显示文章内容 ---------->
                             <div id="page_article_detail" style="display: none"  class="left-conent-page">
                                 <div class="article-detal">
                                     <div class="title"><?=$articleData['title']?></div>
                                     <div class="content"><?=$articleData['body']?></div>
                                 </div>
                             </div>
                             <!--------- 在线聊天室 ---------->
                             <div  id="page_common_list" style="display: none" class="left-conent-page left-content-video">
                                 <div class="page-left scroll" id="post_list_wrap">
                                     <ul id="post_list" class="box-list">
                                         <li  style="" class="box" data-target="0"><span class="glyphicon glyphicon-user"></span> 留言板 </li>
                                     </ul>
                                 </div>
                                 <div class="page-right">

                                     <p class="title"> 频道列表 ：</p>
                                     <ul id="room_list" class="user-list">
                                         <li><span class="glyphicon glyphicon-user" data-groupid="1"></span> 小明 </li>
                                     </ul>

                                    <div style="clear: both"> </div>
                                     <p class="title"> 在线用户列表 ：</p>
                                     <ul id="user_list" class="user-list">
                                         <li><span class="glyphicon glyphicon-user"></span> 小明 </li>
                                         <li><span class="glyphicon glyphicon-user"></span> 秋水 </li>
                                         <li><span class="glyphicon glyphicon-user"></span> 小明 </li>
                                         <li><span class="glyphicon glyphicon-user"></span> 秋水 </li>
                                     </ul>

                                     <div class="sender">
                                         <button  class="btn btn-default" id="btn_send_msg">发帖</button>
                                         <button  class="btn btn-success" id="btn_send_refresh">刷新</button>
                                         <script id="post_editor" type="text/plain"></script>
                                     </div>
                                 </div>

                             </div>
                             <!--------- 显示资料列表 ---------->
                             <div id="page_material_list" style="display: none" class="left-conent-page">
                                 <h5  class="title">资料列表</h5>
                                 <ul id="material_list" class="list-box">
                                     <li class="box row" data-target="{id}">
                                         <div class="col-sm-3"><img src="{cover}"></div>
                                         <div class="col-sm-9 ">
                                            <div class="row"><h5>{title}</h5></div>
                                             <div class="row" style="height: 65px"><p>{desc}</p></div>
                                             <div class="row">
                                                 <b>上传时间 <span>{createdTime}</span></b>
                                                 <a  href="{content}" target="_blank">下载
                                                     <span class="glyphicon glyphicon-download"></span>
                                                 </a>
                                             </div>
                                         </div>
                                     </li>
                                 </ul>
                                 <div style="clear: both"></div>
                             </div>
                             <!--------- 显示资料内容 ---------->
                             <div id="page_material_detal" style="display: none"   class="left-conent-page">
                                 <table border="1">
                                     <tr> <td class="lable">标题</td>   <td class="title"></td></tr>
                                     <tr> <td class="lable">副标题</td> <td class="desc"></td></tr>
                                     <tr> <td class="lable">上传时间</td> <td class="date"></td></tr>
                                     <tr> <td class="lable">下载资料</td> <td class="content">
                                             <a>点击下载<span class="glyphicon glyphicon-download"></span></a></td></tr>
                                 </table>
                             </div>
                             <!--------- 显示视频内容 ---------->
                             <div id="page_video_detal" style="display: none"   class="left-conent-page">
                                 <embed id='videoPlayer' src=''
                                        quality='high' width='480' height='400' align='middle' allowScriptAccess='always'
                                        allowFullScreen='true' mode='transparent' type='application/x-shockwave-flash'>
                                 </embed>
                             </div>
                             <!--------- 显示视频列表 ---------->
                             <div id="page_video_list" style="display: none" class="left-conent-page">
                                 <ul id="viode_list" class="list-box">
                                     <li  style="display: none" class="box" data-target="{id}"> {title} </li>
                                 </ul>
                                 <div style="clear: both"></div>
                             </div>
                             <!--------- 显示知识点列表 ---------->
                             <div id="page_point_list"  class="left-conent-page" style="display: none" >
                                 <h5  class="title">知识点列表</h5>
                                 <ul id="point_list" class="box-list">
                                     <li  style="display: none" class="box" data-target="{id}"> {title} </li>
                                 </ul>
                                 <div style="clear: both"></div>
                             </div>
                             <!--------- 显示知识点内容 ---------->
                             <div id="page_point_detal" style="display: none"  class="left-conent-page">
                                 <div class="pop-page">
                                     <div class="desc">content</div>
                                 </div>
                             </div>

                             <!--------- 显示试卷列表 ---------->
                             <div id="page_exam_list"  class="left-conent-page" style="display: none" >
                                 <h4 class="info"></h4>
                                 <ul id="exam_list" class="list">
                                     <li  style="display" class="box" data-target="{id}"> {title} </li>
                                 </ul>
                                 <div style="clear: both"></div>
                             </div>

                         </div>
                     </div>
                 </div>
                 <!-- ——————章节目录树 ————————-->
                 <div class="float_right tree-warp" style="text-align: center">
                     <div class="toppanel-tree toppanel-hide-up">  </div>
                     <div class="right_title">章节目录</div>
                     <div class="zTreeDemoBackground left">
                         <ul id="treeMap" class="ztree"></ul>
                     </div>
                 </div>
             </div>
         </div>

     </div>
</div>

</div>

<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.exedit.js"></script>
<script type="text/javascript" src="/js/lib/color/jscolor.min.js"></script>
<script type="text/javascript" src="/js/lib/layer/layer.js"></script>

<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/ueditor.all.min.js"> </script>
<script type="text/javascript" charset="utf-8" src="/js/lib/ue/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript" src="/js/common/common.js"></script>
<script type="text/javascript" src="/js/api.js"></script>
<script type="text/javascript" src="/js/lib/pet/pet.js"></script>
<script type="text/javascript" src="/js/controllers/index-detal.js"></script>

</body>
</html>


