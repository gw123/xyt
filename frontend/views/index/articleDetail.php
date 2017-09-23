<?php
  $this->title= '文章:'.$article['title'];
?>

<style>
.panel-heading h4 { margin-top: 0px ;margin-bottom: 0px; line-height: 34px; display: inline-block}
.panel-heading a {color: #9f5b49}
.article-title {
  margin:20px auto 30px;
  text-align:center;
  color: #bf8003;
}
.article-wrap p{  text-indent: 2em;  }
h1, h2, h3, h4, h5, h6 {  color: #080808;  }
.article-content{ color: #120c0c;}
.article-content pre{background-color: rgba(103, 164, 110, 0.65);}
.article-content img{max-width: 100%}
.wrap > .container {  padding: 52px 15px 20px;  }

a:hover, a:focus {  color: #f8b11f;  }

.navbar-nav ul{ background-color: rgba(30, 35, 39, 0.84);  }
.dropdown-menu > li > a{ color: #d5d5d5; }
.dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
  text-decoration: none; color: #d5d5d5;
  background-color: rgba(9, 12, 9, 0.71);
}

</style>
<div class="space-15"></div>
<div class="container">
   <div class="row">
       <div class="panel panel-default">
           <div class="panel-heading ">
               <div class="col-xs-5 col-md-8">
                   <?php foreach ($article['category'] as $key=>$category) {?>
                       <h4>  <a href="/index/article-list?category=<?=$key?>"> <?=$category?> >> </a> </h4>
                   <?php }?>
               </div>
               <div class="col-xs-4 col-md-3">
                   <h4 > 发布者:
                       <a href="/user/index?uid=<?=$article['userId']?>"  > <?=$article['nickname']?></a>
                   </h4>
               </div>
               <div class="col-xs-3 col-md-1" style="text-align: right;">
                   <h4 >
                       <?php if($isCollect){ ?>
                           <a href="/user/cancel-collect?type=article&cid=<?=$article['id']?>" class="btn btn-sm btn-success"> 取消收藏</a>
                       <?php }else {?>
                           <a href="/user/collection?type=article&cid=<?=$article['id']?>" class="btn btn-sm btn-success"> 收藏</a>
                       <?php }?>
                   </h4>
               </div>
               <div style="clear: both"></div>
           </div>

           <div class="panel-body">
               <h3  class="article-title">   <?=$article['title']?></h3>
               <div class="article-content" style="margin: 10px 0px;">  <?=$article['body']?>  </div>

               <div class="share" style="float: right">
                   <!-- JiaThis Button BEGIN -->
                   <div class="jiathis_style_24x24">
                       <a class="jiathis_button_qzone"></a>
                       <a class="jiathis_button_tsina"></a>
                       <a class="jiathis_button_tqq"></a>
                       <a class="jiathis_button_weixin"></a>
                       <a class="jiathis_button_renren"></a>
                       <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt jtico jtico_jiathis" target="_blank"></a>
                       <a class="jiathis_counter_style"></a>
                   </div>
                   <script type="text/javascript" src="http://v3.jiathis.com/code/jia.js" charset="utf-8"></script>
                   <!-- JiaThis Button END -->
               </div>
           </div>
       </div>

       <!--- 评论模块 -->
       <?= $this->render('/template/comment' , ['comments'=>$comments , 'type'=>'article' ,'id'=>Yii::$app->request->get('id')]); ?>

   </div>
</div>








