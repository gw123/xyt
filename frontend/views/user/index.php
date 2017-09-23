<?php
 use frontend\widgets\MeituWidget;
?>
<div class="page-content">
        <div class="row">
            <div class="col-xs-12">
                <!-- PAGE CONTENT BEGINS -->
                <div class="hr dotted"></div>
                <div>
                    <div id="user-profile-1" class="user-profile row">
                        <div class="col-xs-12 col-sm-3 center">
                            <div>
                                <span class="profile-picture">
                                    <img id="avatar" class="editable img-responsive"  src="<?=$setting['mediumAvatar']?>" />
                                    <?= MeituWidget::widget(
                                        ['name'=>'avator',
                                        'serverUrl'=>'/uploader/upload-image',
                                        'repaceImageId'=>'avatar'
                                       ])
                                    ?>
                                </span>

                                <div class="space-4"></div>

                                <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                    <div class="inline position-relative">
                                        <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                            <i class="icon-circle light-green middle"></i>
                                            <span class="white"><?= $setting['nickname'] ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="space-6"></div>
                            <?php if(!$isSelf) {?>
                            <div class="profile-contact-info">
                                <div class="profile-contact-links align-left">
                                    <a class="btn btn-link" href="#">
                                        <i class="icon-envelope bigger-120 pink"></i>发送消息
                                    </a>
                                    <?php if (!$isCollect){ ?>
                                        <a href="/user/collection?type=user&cid=<?=$setting['uid']?>" class="btn btn-link" >
                                            <i class="icon-globe bigger-125 blue"></i>关注
                                        </a>
                                    <?php }else{?>
                                        <a href="/user/cancel-collect?type=user&cid=<?=$setting['uid']?>" class="btn btn-link" >
                                            <i class="icon-globe bigger-125 blue"></i>取消关注
                                        </a>
                                    <?php } ?>
                                </div>
                                <div class="space-6"></div>
                            </div>
                            <?php }?>

                            <div class="hr hr12 dotted"></div>
                        </div>

                        <div class="col-xs-12 col-sm-9">
                            <div class="center">
                                    <span class="btn btn-app btn-sm btn-light no-hover">
                                        <span class="line-height-1 bigger-170 blue"> <?=$userAbout['articleTotal']?> </span><br />
                                        <span class="line-height-1 smaller-90"> 文章 </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-yellow no-hover">
                                        <span class="line-height-1 bigger-170"> <?=$userAbout['videoTotal']?> </span><br />
                                        <span class="line-height-1 smaller-90"> 视频 </span>
                                    </span>

                                <span class="btn btn-app btn-sm btn-pink no-hover">
                                        <span class="line-height-1 bigger-170"> <?=$userAbout['followTotal']?> </span><br />
                                        <span class="line-height-1 smaller-90"> 关注 </span>
                                    </span>

                                <span class="btn btn-app btn-sm btn-success no-hover">
                                    <span class="line-height-1 bigger-170"> <?=$userAbout['materialTotal']?> </span><br />
                                    <span class="line-height-1 smaller-90"> 资料 </span>
                                </span>

                                <span class="btn btn-app btn-sm btn-primary no-hover">
                                    <span class="line-height-1 bigger-170"> <?=$userAbout['bookTotal']?> </span><br />
                                    <span class="line-height-1 smaller-90"> 书籍 </span>
                                </span>
                            </div>

                            <div class="space-12"></div>
<!--- 用户资料-->
                            <div class="profile-user-info profile-user-info-striped">
                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 用户名 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="username"> <?= $setting['nickname'] ?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 城市 </div>
                                    <div class="profile-info-value">
                                        <i class="icon-map-marker light-orange bigger-110"></i>
                                        <span class="editable" id="country"><?= $setting['city']?> </span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 出生日期 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="age"><?= $setting['birthday']?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 兴趣 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="signup"><?= $setting['interest']?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 微博 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="about"><?= $setting['weibo']?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 签名 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="login"><?= $setting['signature']?></span>
                                    </div>
                                </div>

                                <div class="profile-info-row">
                                    <div class="profile-info-name"> 自我简绍 </div>
                                    <div class="profile-info-value">
                                        <span class="editable" id="about"><?= $setting['about']?></span>
                                    </div>
                                </div>

                            </div>

                            <div class="space-20"></div>

                            <div class="widget-box transparent">
                                <div class="widget-header widget-header-small">
                                    <h4 class="blue smaller"><i class="icon-rss orange"></i>近期活动</h4>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main padding-8">
                                        <div id="profile-feed-1" class="profile-feed">

                                            <?php foreach ($recentActivity as $row){?>
                                            <div class="profile-activity clearfix">
                                                <div>
                                                     <span style="font-weight:600;color: #c3a3a3"> <?=$row['type']?></span>
                                                    <a class="user" href="<?=$row['href']?>"> <?=$row['title']?></a>
                                                    <div class="time"><i class="icon-time bigger-110"></i> <?=$row['createdTime']?></div>
                                                </div>
                                            </div>
                                            <?php }?>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="hr hr2 hr-double"></div>

                        </div>
                    </div>
                </div>

                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
 </div><!-- /.page-content -->

<script>

</script>
