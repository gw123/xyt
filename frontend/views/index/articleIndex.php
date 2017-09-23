
<div id="middle">
       <script>
           var recommendArticles = <?php echo json_encode($recommendArticles);?>;
           var articleCategorys  = <?php echo json_encode($articleCategorys);?>;
           var hotArticle         = <?php echo json_encode($hotArticle)?>;
           var lastArticle        = <?php echo json_encode($lastArticle)?>;
       </script>
   <div class="container">
        <!-- 轮播 -->
       <style>
           #kit-slideshow img{width: 1000px;  height: 532px; }
       </style>
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
           <div class="kit-navi">
               <a id="kit-navi-prev" href="#"></a>
               <span id="kit-title"></span>
               <a id="kit-navi-next" href="#"></a>
           </div>
      </div>

        <!-- 主分类列表   置顶帖子 -->
        <div class="details_left">
           <!-- 导航 -->
           <div class="middle-left-nav article-categorys">
               <a href="javascript:;" class="article-category" id="0">综合</a>
               <?php
                 foreach ($articleCategorys as $category)
                 { echo "<a href='javascript:;' id='{$category['id']}' class='article-category'>{$category['title']}</a> "; }
               ?>
            </span>
           </div>
           <!--主列表 -->
           <div class="middle-left-list main-article-list" style="display:block">
               <ul>
                   <li>
                       <div class="pic"><a href="" target="_blank">
                           <img src="/images/default.png"></a>
                           <p><a href="" target="_blank">系统</a></p>
                       </div>
                       <div class="rinfo">
                           <a href="" target="_blank">biaoti</a>
                           <p>desc</p>
                           <div class="time"><i>2017-02-10</i><span>
                            <a href="http://www.51cto.com/php/search.php?q=操作技巧 " target="_blank" class="tag">操作技巧 </a>
                            <a href="http://www.51cto.com/php/search.php?q=Windows" target="_blank" class="tag">Windows</a>
                           </span>
                           </div>
                       </div>
                       <div class="fx">
                           <div class="fxlist bdsharebuttonbox bdshare-button-style0-24" id="share" data-bd-bind="1486870590287">
                               <p>
                                   <a class="bds_tsina" data-cmd="tsina"></a>
                                   <a class="bds_qzone" data-cmd="qzone"></a>
                                   <a class="bds_sqq" data-cmd="sqq"></a>
                                   <a class="bds_weixin" data-cmd="weixin"></a>
                               </p>
                           </div>
                       </div>
                    </li>
               </ul>
           </div>
        </div>
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
        <div class="clear"></div>
   </div>
</div>

<div class="divider"></div>

<script type="application/javascript" src="/js/jquery-2.1.4.js"></script>
<script type='text/javascript' src='/js/lib/scroll/jquery.carouFredSel.min.js'></script>
<script type="text/javascript" src="/js/lib/layer/layer.js"></script>
<script type="text/javascript" src= '/js/common/common.js'></script>
<script type="text/javascript" src= '/js/api.js'></script>
<script type="text/javascript" src="/js/index.js"></script>




