<?php
$this->title= '通知:'.$notification['title'];
?>

<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style>
    .panel-heading h4 { margin-top: 0px ;margin-bottom: 0px; line-height: 34px; display: inline-block}
    .panel-heading a {color: #6d6464}
    .article-title {
        margin:20px auto 30px;
        text-align:center;
        color: #bf8003;
    }
    .article-wrap p{  text-indent: 2em;  }
    h1, h2, h3, h4, h5, h6 {  color: #080808;  }
    pre{background-color: rgba(15, 164, 38, 0.65);}
    .wrap > .container {  padding: 52px 15px 20px;  }
    a {  color: #ecd5be;  }
    a:hover, a:focus {  color: #f8b11f;  }

    .navbar-nav ul{ background-color: rgba(30, 35, 39, 0.84);  }
    .dropdown-menu > li > a{ color: #d5d5d5; }
    .dropdown-menu > li > a:hover, .dropdown-menu > li > a:focus {
        text-decoration: none; color: #d5d5d5;
        background-color: rgba(9, 12, 9, 0.71);
    }
</style>
<div class="panel panel-default">
    <div class="panel-heading ">
       <h4> 通知 </h4>
    </div>

    <div class="panel-body" style="min-height: 600px;">
        <h3  class="article-title">   <?=$notification['title']?></h3>
        <div class="article-content">  <?=$notification['content']?>  </div>
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






