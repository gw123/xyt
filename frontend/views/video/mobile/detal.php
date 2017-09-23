<?php
/* @var $this yii\web\View */
//$this->registerJsFile("@web/js/lib/danmu/lib/jquery-1.11.1.min.js",['depends' =>[yii\web\YiiAsset::className()]]);
//$this->registerJsFile("@web/js/lib/danmu/danmuplayer.js",['depends' =>[yii\web\YiiAsset::className()]]);
//$this->registerCssFile("@web/js/lib/danmu/danmuplayer.css");
//
?>
<link href="/js/lib/danmu/css/scojs.css" rel="stylesheet">
<link href="/js/lib/danmu/css/colpick.css" rel="stylesheet">
<link href="/js/lib/danmu/css/bootstrap.css" rel="stylesheet">
<link href="/js/lib/danmu/css/main.css" rel="stylesheet">
<script src="/js/lib/danmu/jquery-2.1.4.min.js"></script>
<script src="/js/lib/danmu/jquery.shCircleLoader.js"></script>
<script src="/js/lib/danmu/sco.tooltip.js"></script>
<script src="/js/lib/danmu/colpick.js"></script>
<script src="/js/lib/danmu/jquery.danmu.js"></script>
<script src="/js/lib/danmu/main.js"></script>
<style >
     .video{width: 100%;margin: 0 auto;}
</style>
<div class="video">
    <div id="danmup" > </div>
</div>
<!--DanmuPlayer (//github.com/chiruom/danmuplayer/) - Licensed under the MIT license-->
<script>
        $("#danmup").DanmuPlayer({
            src:"<?= $model->content?>",
            height: "450px", //区域的高度
            width: "100%" //区域的宽度
            , urlToGetDanmu: "/video/get-danmu"
            , urlToPostDanmu: "/video/post-danmu"
        });
        $("#danmup .danmu-div").danmu("addDanmu", [
            {"text": "这是滚动弹幕", color: "white", size: 1, position: 0, time: 2}
            , {"text": "我是帽子绿", color: "green", size: 1, position: 0, time: 3}
            , {"text": "哈哈哈啊哈", color: "black", size: 1, position: 0, time: 10}
            , {"text": "这是顶部弹幕", color: "yellow", size: 1, position: 1, time: 3}
            , {"text": "这是底部弹幕", color: "red", size: 1, position: 2, time: 9}
            , {"text": "大家好，我是伊藤橙", color: "orange", size: 1, position: 1, time: 3}
        ]);
</script>
