<?php
$this->title= "资料：".$data['title'];
?>
<style>
    .panel-heading h4 { margin-top: 0px ;margin-bottom: 0px; line-height: 34px; display: inline-block}
    .panel-heading a {color: #6d6464}
    .main-title {
        margin:10px auto 30px;
        text-align:center;
        color: #bf8003;
    }
    .material-content{ width: 90%; max-width:800px; margin: 0 auto;}
    a:hover{ text-decoration: none ; color: #00aa00}
</style>
<div class="space-15"></div>
<div class="container" >
    <div class="panel panel-default">
        <div class="panel-heading ">
            <div class="col-xs-5 col-md-8">
                <h4>  <a href="/index/material-list"> 资源列表>> </a> </h4>
                <?php foreach ($data['category'] as $key=>$category) {?>
                    <h4>  <a href="/index/material-list?category=<?=$key?>"> <?=$category?> >> </a> </h4>
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
                        <a href="/user/cancel-collect?type=material&cid=<?=$data['id']?>" class="btn btn-sm btn-success"> 取消收藏</a>
                    <?php }else {?>
                        <a href="/user/collection?type=material&cid=<?=$data['id']?>" class="btn btn-sm btn-success"> 收藏</a>
                    <?php }?>
                </h4>
            </div>
            <div style="clear: both"></div>
        </div>

        <div class="panel-body">
            <h3  class="main-title"><?=$data['title']?></h3>
            <div class="material-content">
                <div class="material-desc">
                    <?=$data['desc']?>
                    <img class="img-responsive" src="<?=$data['cover']?$data['cover']:Yii::$app->params['MaterialDefaultImage']?>">
                </div>
                <div>
                    <h4> <a href="<?=$data['content']?>" target="_blank">下载</a>   </h4>
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
    <?= $this->render('/template/comment' , ['comments'=>$comments , 'type'=>'material' ,'id'=>Yii::$app->request->get('id')]); ?>

</div>
