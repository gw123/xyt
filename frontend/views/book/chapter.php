<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = "章节管理";
$this->params['breadcrumbs'][] = ['label' => '我的书籍', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $bookName, 'url' => ['/book/view?id='.$bookId]];
$this->params['breadcrumbs'][] = $this->title;
?>

<link rel="stylesheet" href="/js/lib/tree/css/zTreeStyle/zTreeStyle.css" type="text/css">
<link rel="stylesheet" href="/css/tree.css" type="text/css">
<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.core.js"></script>
<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.excheck.js"></script>
<script type="text/javascript" src="/js/lib/tree/js/jquery.ztree.exedit.js"></script>

<script>
    var  bookName = '<?=$bookName?>';
    var  treeMap       = <?=json_encode($treeMap)?>;
</script>
<div class="widget-box">
    <div class="widget-header header-color-dark">
        <h5 class="bigger lighter"><?=$bookName?></h5>
        <button class="pull-right  btn-warning btn-sm">展开所有节点</button>
        <button class="pull-right  btn-warning btn-sm">收缩节点</button>
        <a href="/book/import-chapter?id=<?=Yii::$app->request->get('id')?>">
            <button class="pull-right  btn-warning btn-sm">批量导入章节</button>
        </a>
    </div>

    <div class="widget-body">
        <div class="widget-main row">
            <div class="col-sm-5" style="border-right: dashed">
                <ul id="treeMap" class="ztree"></ul>
            </div>
            <!---章节内容编辑区 -->
            <div class="col-sm-7" style="position: relative">

                <div class="row" style="text-align: center">
                    <div class="col-xs-4">
                        <button class="btn btn-app  btn-danger btn-sm " onclick="addBtn('article')">
                            <i class="icon-edit bigger-160"></i>添加文章
                        </button> </div>
                    <div class="col-xs-4">
                        <button class="btn btn-app btn-warning btn-sm" onclick="addBtn('material')">
                            <i class="icon-cloud-upload bigger-160"></i>添加资料
                        </button>
                    </div>
                    <div class="col-xs-4">
                        <button class="btn btn-app btn-pink btn-sm" onclick="addBtn('video')">
                            <i class="icon-film  bigger-160"></i>添加视频
                        </button>
                    </div>
                </div>

                <div class="vspace-xs-6"></div>
                <div class="row">
                    <div class="tabbable">
                            <ul class="nav nav-tabs" id="chapter">
                                <li class="active " style="width: 33.3%">
                                    <a data-toggle="tab" href="#tab_article">
                                        <i class="green icon-lightbulb bigger-110"></i>
                                        章节文章
                                    </a>
                                </li>

                                <li style="width: 33.3%">
                                    <a data-toggle="tab" href="#tab_video">
                                        <i class="green icon-lightbulb bigger-110"></i>
                                       章节视频
                                    </a>
                                </li>

                                <li style="width: 33.3%">
                                    <a data-toggle="tab"  href="#tab_material">
                                        <i class="green icon-lightbulb bigger-110"></i>
                                       章节资料
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="tab_article" class="tab-pane in active">
                                   <ul></ul>
                                </div>

                                <div id="tab_video" class="tab-pane">
                                   <ul></ul>
                                </div>

                                <div id="tab_material" class="tab-pane">
                                    <ul></ul>
                                </div>
                            </div>
                        </div>
                </div>

            </div>
            <!---章节内容编辑区End -->
        </div>
    </div>
</div>
<!-- 自定义的操作dom 元素的方法最好放到最后面 -->
<script type="text/javascript" src= '/js/api.js'></script>
<script type="text/javascript" src="/js/controllers/book-chapter.js"></script>
<script>

</script>


