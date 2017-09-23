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
     body{background: rgba(25, 25, 25, 0.95)
     }
     .video{width: 100%;margin: 0 auto;}
</style>
<div class="video">
    <div    id="danmup" > </div>
    <embed id="normalPlayer" src=''
           quality='high' width='480' height='400' align='middle' allowScriptAccess='always' allowFullScreen='true'
           mode='transparent' type='application/x-shockwave-flash'></embed>
</div>
<!--DanmuPlayer (//github.com/chiruom/danmuplayer/) - Licensed under the MIT license-->
<script>
      <?php
         $type = '';
        if( strpos( $model['content'] ,'http://player.youku.com' )===0 )
        {
            $type = 'youku';
        }else{
            $type = 'local';
        }

        if($type=='youku')
        {
            $playerJs = '$("#normalPlayer").attr("src","'. $model['content'] .'");';
            $playerJs.= '$("#danmup").hide()';
        }else if($type=='local')
        {
            $playerJs = ' $("#danmup").DanmuPlayer({
             src:"'. $model['content'].'",
             height: "90%", //区域的高度
             width: "100%" //区域的宽度
             , urlToGetDanmu: "/video/get-danmu"
             , urlToPostDanmu: "/video/post-danmu"
             });
             $("#danmup .danmu-div").danmu("addDanmu", danmus);';
            $playerJs.= '$("#normalPlayer").hide()';

        }

        echo " var  danmus =  [ {$danmus}] ;";
        echo $playerJs;
      ?>



</script>
