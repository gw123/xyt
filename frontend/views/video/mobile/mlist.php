<?php
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
?>
<style>
      body .wrap > .container {  padding: 10px 15px 20px; font-family: Microsoft YaHei, Helvitica, Verdana, Tohoma, Arial, san-serif; }

     .mainmenu {  width: 100%;  margin: auto;  padding: 0px;  overflow: hidden;  }
      ul {  list-style: none outside none;  }
     .mainmenu li {  float: left;  margin-left: 5%;  margin-top: 5%;  width: 42.5%;  }
     .mainmenu li a {  display: block;  overflow: hidden;  }
     .mainmenu li a p {
         background-color: #444444;
         border-radius: 7px;
         text-align: center;
         position: relative;
         box-shadow: 0px 2px 3px rgba(0, 0, 0, 0.35);
         padding-bottom: 10px;
         height: 99px;
     }
      .mainmenu li a p img { margin: 0 auto;    height: 99px;  }
     .mainmenu li a p span {
         position: absolute;
         z-index: 100;
         top: 50px;
         left: 10%;
         clear: both;
         display: block;
         margin: auto;
         width: 80%;
         height: 32px;
         line-height: 16px;
         overflow: hidden;
         text-align: center;
         color: #ff7835;
         font-size: 12px;
     }
     .mainmenu li b {
         display: block;
         margin-top: 15px;
         text-align: center;
         line-height: 30px;
         text-overflow: ellipsis;
         overflow: hidden;
         white-space: nowrap;
         background-color: rgba(0, 0, 0, 0.35);
         border-radius: 4px;
         font-weight: normal;
         padding: 0px 10px;
         color: #FFF;
     }

</style>
<link href="/css/mobile/css.css" rel="stylesheet" type="text/css">

 <ul class="mainmenu">

     <?php  foreach( $models as $index =>$video ){?>
         <li >
             <a  href="mdetal?id=<?=$video['id']?>" >
                 <p>
                     <img src="/image/video/video1.png">
                     <span> <?=mb_substr($video['desc'],0,46) ?> </span>
                 </p>
                 <b><?=$video['title']; ?></b>
             </a>
         </li>
     <?php } ?>
 </ul>




<div class="right"> <?php echo LinkPager::widget(['pagination' => $pages,]) ?> </div>

<script type="text/javascript">

</script>
