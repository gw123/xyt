<?php
  if(Yii::$app->user->isGuest)
  {
      header('location: /site/login ');exit();
  }
?>
<div class="navbar navbar-default" id="navbar">
    <script type="text/javascript">
        try{ace.settings.check('navbar' , 'fixed')}catch(e){}
    </script>

    <div class="navbar-container" id="navbar-container">
        <div class="navbar-header pull-left">
            <div href="#" class="navbar-brand">
              <small><a href="/" alt="跳转到网站首页" ><i class="icon-leaf"></i></a>用户中心</small>
            </div><!-- /.brand -->
        </div><!-- /.navbar-header -->

        <div class="navbar-header pull-right" role="navigation">
            <ul class="nav ace-nav">
                <li class="light-blue">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="/home/avatars/user.jpg" alt="Jason's Photo" />
                        <span class="user-info">
                            <small>欢迎光临,</small><?= Yii::$app->user->identity->username?>
                        </span>
                        <i class="icon-caret-down"></i>
                    </a>

                    <ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li><a href="/user/setting">   <i class="icon-cog"></i> 设置</a></li>
                        <li><a href="/user/index">     <i class="icon-user"></i> 个人资料</a></li>
                        <li><a href="/user/my-collection"><i class="icon-heart"></i> 我的收藏</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" onclick="UserService.logout()"><i class="icon-off"></i> 退出</a>
                        </li>
                    </ul>
                </li>
            </ul><!-- /.ace-nav -->
        </div><!-- /.navbar-header -->
    </div><!-- /.container -->
</div>