<div class="sidebar" id="sidebar">
    <script type="text/javascript">

    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <a href="/index/profit/paylog.html" class="btn btn-success"><i class="icon-shopping-cart"></i></a>

            <a href="/index/channel/cnzz.html" class="btn btn-info"> <i class="icon-user-md"></i></a>

            <a href="/index/tuiguang/wenan.html" class="btn btn-warning"><i class="icon-group"></i></a>

            <a href="/index/help/liucheng.html" class="btn btn-danger"><i class="icon-rss"></i></a>

        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
        <li class="active">
            <a href="#">
                <i class="icon-dashboard"></i>
                <span class="menu-text">功能</span>
            </a>
        </li>

        <?php  $menus = Yii::$app->params['menus'];  ?>

        <?php  foreach ($menus as $subMenus) { ?>
        <li>
            <a href="#"  class="dropdown-toggle" data-toggle="dropdown">
                <i class="<?=$subMenus['icon']?$subMenus['icon']:' icon-edit'?>"></i>
                <span class="menu-text"><?=$subMenus['title']?></span>
                <b class="arrow icon-angle-down"></b>
            </a>
            <ul class="submenu ">
            <?php  foreach ($subMenus['sons'] as $menu) { ?>
                <li>
                    <a id='test' href="<?=$menu['url']?>"><i class="icon-double-angle-right"></i><?=$menu['title']?></a>
                </li>
            <?php }?>
            </ul>
        </li>
        <?php }?>

    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
        <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>
    <script type="text/javascript">
        try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
        //  try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
        $(function() {
            $('.submenu').show()
            var  url = window.location.pathname;
            $('li [href="'+url+'"]').css('background-color','#8eff9559');
        });
    </script>
</div>