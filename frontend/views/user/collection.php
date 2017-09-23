<?php
 $this->title = '我的收藏';
?>
<style >
    .timeline-label a,.timeline-label a:hover{
        color: #0a2b1d;
    }
</style>
<div id="timeline-1">
    <div class="row">
        <div class="col-xs-12 col-sm-10 col-sm-offset-1">
            <div class="timeline-container">
                <div class="timeline-label">
                    <span class="label label-warning arrowed-in-right label-lg">
                      <a href="/user/my-collection?type=book"> <b>收藏书籍</b></a>
                    </span>
                    <span class="label label-warning arrowed-in-right label-lg">
                       <a href="/user/my-collection?type=article"> <b>收藏文章</b></a>
                    </span>
                    <span class="label label-warning arrowed-in-right label-lg">
                       <a href="/user/my-collection?type=video"> <b>收藏视频</b></a>
                    </span>
                    <span class="label label-warning arrowed-in-right label-lg">
                       <a href="/user/my-collection?type=material"> <b>收藏资料</b></a>
                    </span>
                </div>

                <div class="timeline-items">
                    <?php foreach ($rows as $row){?>
                        <div class="timeline-item clearfix">
                            <div class="timeline-info">
                                <i class="timeline-indicator icon-star btn btn-warning no-hover green"></i>
                            </div>
                            <div class="widget-box transparent">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <a href="/index/article-detail?id=<?=$row['id']?>" target="_blank"> <?=$row['title'] ?> </a>
                                        <div class="pull-right action-buttons">
                                            <div class="space-4"></div>
                                            <div>
                                                <a href="#"><i class="icon-reply light-green bigger-130"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div><!-- /.timeline-items -->
            </div><!-- /.timeline-container -->

        </div>
    </div>
</div>
