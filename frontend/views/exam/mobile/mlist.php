<?php
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;
?>
<style>
     body .wrap > .container {  padding: 10px 15px 20px;  }
    .mylist .badge{ float: right}
    .mylist img{width: 100px;height:60px:overflow: hidden}

     @media screen and (min-width: 480px) and (max-width: 780px) {
         .col-sm-3 {
             width: 25%;
             float: left;
         }
         .col-sm-9 {
             width: 75%;
             float: left;
         }
     }
</style>
<link href="/css/mobile/css.css" rel="stylesheet" type="text/css">
<ul class="list-group mylist">

    <?php  foreach( $models as $index =>$exam ){?>
    <li class="list-group-item list-group-item-success row">
        <div class="col-sm-3"><img src="/image/exam/exam_1.png"></div>
        <div class="col-sm-9">
             <a href="mexam-detal?id=<?=$exam['id']?>">
             <h3 class="list-group-item-heading">  <?=$exam['title']; ?>
             <span class="badge">新</span> </h3>
            </a>
            <p class="list-group-item-text"> 试卷描述 </p>
        </div>
    </li>
    <?php } ?>

</ul>

<div class="right" style="float: right"> <?php echo LinkPager::widget(['pagination' => $pages,]) ?> </div>

<script type="text/javascript">

</script>
