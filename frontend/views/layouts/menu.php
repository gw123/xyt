<?php

?>
<style>
     .left_menu{ position: fixed ; top: 0px;  left:0px;  width:20%; height:90%; background-color: #9b2eff; z-index: 1000 ;color: #000; }
     .left_menu ul { padding: 0; margin: 20px 0 0 0; overflow: hidden ;list-style: none;}
     .left_menu ul li{ padding: 5px 0 ; margin:0 10%; font-weight: 700;border-bottom: groove; text-indent: 1em; }
     .left_menu ul li a{color: #5bff70  ;overflow: hidden;}
     .left_menu .left_door{position: absolute;top: 0px;right: 0px; width: 10%; height: 100%; background-color: #ff0000;opacity: 0.5; z-index: 1001}

</style>

<div class="left_menu">
    <ul>
        <li> <a href="/index/mindex"> 首页</a> </li>
        <li> <a href="/exam/mlist"> 试卷</a> </li>
        <li> <a href="/video/mlist"> 精品视频</a> </li>
        <li> <a href="/book/mlist"> 考研教辅</a> </li>
        <li> <a href="/book/mlist"> 精品试题</a> </li>
        <li> <a href="/book/mlist"> 暗黑实验</a> </li>
        <li> <a href="/news/mlist"> 考研动态</a> </li>
        <li> <a href="/play/mlist"> 减压神器</a> </li>
    </ul>
    <div class="left_door">

    </div>
</div>

<script>
     window.onload = function () {
         var  door=0;
         $('.left_door').click(function () {
             console.log(door);
             if (door == 0)
             {
                 door=1;  $('.left_menu').css('width','12px');
                          $('.left_menu ul').css('display','none');
                 $(this).css('width','100%');
             }
             else{
                 door=0 ; $('.left_menu').css('width','20%');
                          $('.left_menu ul').css('display','block');
                 $(this).css('width','10%');
             }
         });
     }

</script>