<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\Chapter;
use common\models\Tag;
use common\utils\Constant;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程管理';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?php //echo Html::a('Create Course', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'id', //必须加这个
                'format'=>'raw',
                'value'=>function($m){
                    return $m->id;
                },
                'headerOptions' => ['width' => '10'],
            ],
            [
                'attribute'=>'userId',
                'label'=>'用户',
                'value'=>function($m){
                    return  User::getNickNameById($m->userId);
                },
            ],
            'title',
            [
                'attribute'=>'subtitle',
                'label'=>'副标题',
                'format'=>'raw',
                'value'=>function($m){
                   $str = "<small>".mb_substr($m->subtitle ,0,30)."</small>";
                   return $str;
                },
                //'filter' => Constant::$CaiJiStatus,
            ],
            [
                'attribute'=>'status',
                'label'=>'状态',
                'value'=>function($m){
                    if( isset(Constant::$CourseStatus [ $m->status ]) )
                        return  Constant::$CourseStatus [ $m->status ];
                    else{
                        return "未知";
                    }
                },
                'filter' => Constant::$CourseStatus,
            ],
            [
                'attribute'=>'category',
                'label'=>'目录',
                'format'=>'raw',
                'value'=>function($m){
                    $category = \common\models\CategorySearch::getLastCategoryName($m->category);
                    $str = '<button class="btn chooserCategoryBtn" data-id="'. $m->id .'">'.$category.'</button>';
                    return $str;
                },
            ],
            [
                'attribute'=>'chapter',
                'label'=>'章节',
                'format'=>'raw',
                'value'=>function($m){
                    $chapter = \common\models\Chapter::getLastChapterName($m->chapter);
                    $str = '<button class="btn chooserChapterBtn" data-id="'. $m->id .'">'.$chapter.'</button>';
                    return $str;
                },
            ],
            [
                'attribute'=>'recommended',
                'label'=>'推荐级别',
                'format'=>'raw',
                'value'=>function($m){
                    if( isset(Constant::$RecommenLvl [ $m->recommended ]) )
                       return  Constant::$RecommenLvl [ $m->recommended ];
                    else{
                        return "等级太高";
                    }
                },
                'filter' => Constant::$RecommenLvl,
                'headerOptions' => ['width' => '40'],
            ],
            // 'type',
            // 'price',
            // 'middlePicture',
            // 'parentId',

            // 'createdTime',
            // 'locked',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>


<!---模态框列表 --->
<!---章节选择模态框--->
<div class="modal fade" id="chapterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    选择章节
                </h4>
            </div>
            <div class="modal-body cascade-select"  id="select_chapter">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="save_chapter">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">
                    选择目录
                </h4>
            </div>
            <div class="modal-body cascade-select"  id="select_category">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="save_category">保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    var  currentRowId = '';

    $('.chooserCategoryBtn').click(function () {
        currentRowId =  $(this).attr('data-id');
        console.log(currentRowId);
        $('#categoryModal').modal('show');
    });
    $('#save_category').click(function () {
        var  categorys = $('#select_category').children(':visible');
        var  categoryStr = '';
        for(var i=0 ; i<categorys.length ; i++)
        {
            categoryStr += categorys[i].value + ",";
        }
        categoryStr =  categoryStr.substr(0 ,categoryStr.length-1);
        $.ajax({
            url : '/course/change-category' ,
            data :{  id : currentRowId ,  category : categoryStr },
            dataType:'json',
            success: function (response) {
                if(response.status)
                {
                    window.location.reload();
                    $('#categoryModal').modal('hide');
                }else{
                    alert('修改失败');
                }
            },
            error: function () {  alert('修改目录失败, 网络错误');  }
        })
    });
    var lvl_category = <?=json_encode(\common\models\CategorySearch::getLvl1CourseCategory())?>;
    //初始化目录数据
    var categoryconfig = {
        'firstData' :lvl_category,
        'selector'  : "#select_category",
        'serverUrl' : '/category/get-category-sons',
    };
    CascadeSelect(categoryconfig);

    $('.chooserChapterBtn').click(function () {
           currentRowId =  $(this).attr('data-id');
           //console.log(currentRowId);
          $('#chapterModal').modal('show');
    });
    $('#save_chapter').click(function () {
           var  chapters = $('#select_chapter').children(':visible');
           var  chapterStr = '';
           for(var i=0 ; i<chapters.length ; i++)
           {
               chapterStr += chapters[i].value + ",";
           }
          chapterStr =  chapterStr.substr(0 ,chapterStr.length-1);
          // console.log(chapterStr);
         // 修改条数据的章节信息
         $.ajax({
             url : '/course/change-chapter' ,
             data :{  id : currentRowId ,  chapter : chapterStr },
             dataType:'json',
             success: function (response) {
                 if(response.status)
                 {
                      window.location.reload();
                     $('#chapterModal').modal('hide');
                 }else{
                    alert('修改失败');
                 }
             },
             error: function () {
                 alert('修改失败章节, 网络错误');
             }
         })
    });
    var lvl_chapter = <?=json_encode(Chapter::getLvl1Chapter())?>;
    //初始化章节数据
    var chapterconfig = {
        'firstData' :lvl_chapter,
        'selector'  : "#select_chapter",
        'serverUrl' : '/chapter/get-chapter-sons',
    };
    CascadeSelect(chapterconfig);


</script>
