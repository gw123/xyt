<?php
  $this->title= "视频".$data['title'];
?>

<style>
    .panel-heading h4 { margin-top: 0px ;margin-bottom: 0px; line-height: 34px; display: inline-block}
    .panel-heading a {color: #6d6464}
    .main-title {
        margin:10px auto 30px;
        text-align:center;
        color: #bf8003;
    }
    .video-content{ width: 90%; max-width:800px; margin: 0 auto;}
</style>
<div class="space-15"></div>
<div class="container">
    <div class="panel panel-default">
        <div class="panel-heading ">
            <div class="col-xs-5 col-md-8">
                <?php foreach ($data['category'] as $key=>$category) {?>
                    <h4>  <a href="/index/video-list?category=<?=$key?>"> <?=$category?> >> </a> </h4>
                <?php }?>
            </div>
            <div class="col-xs-4 col-md-3">
                <h4 > 发布者:
                    <a href="/user/index?uid=<?=$data['userId']?>"  > <?=$data['nickname']?></a>
                </h4>
            </div>
            <div class="col-xs-3 col-md-1" style="text-align: right;">
                <h4 >
                    <?php if($isCollect){ ?>
                        <a href="/user/cancel-collect?type=video&cid=<?=$data['id']?>" class="btn btn-sm btn-success"> 取消收藏</a>
                    <?php }else {?>
                        <a href="/user/collection?type=video&cid=<?=$data['id']?>" class="btn btn-sm btn-success"> 收藏</a>
                    <?php }?>
                </h4>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body">
            <h3  class="main-title">   <?=$data['title']?></h3>
            <div class="video-content">
                <video width="100%"  controls class="video">
                    <source class="upload_dispaly" src="<?=$data['content']?>" type="video/mp4">
                    <object data="movie.mp4" width="320" height="240">
                        <embed width="320" height="240" class="upload_dispaly" src="<?=$data['content']?>">
                    </object>
                </video>

                <div class="video-desc">
                    <?=$data['desc']?>
                </div>
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
    </div>

    <!--- 评论模块 -->
    <?= $this->render('/template/comment' , ['comments'=>$comments , 'type'=>'video' ,'id'=>Yii::$app->request->get('id')]); ?>

</div>






