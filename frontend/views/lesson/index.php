<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
use common\models\Chapter;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CourseLessonSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Lessons';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="course-lesson-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
       <?php  $eduHost = Yii::$app->params['EduHost'];  ?>
        <?= Html::a('创建课程', ['create'], ['class' => 'btn btn-success']) ?>
        <?php  echo "<a href='{$eduHost}/course/1/manage/lesson' class='btn btn-success' target='_blank'> 创建试卷</a>"; ?>
    </p>
    <?php  global $courseMap ;$courseMap = \common\models\CourseSearch::getMap();  ?>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
           // 'id',
            [ 'attribute'=>'id', 'headerOptions' => ['width' => '10'] ],
            [
                'attribute'=>'courseId',
                'format'=>'raw',
                'value'=>function($m)
                {
                    global $courseMap ;
                    return  $courseMap[$m->courseId];
                },
            ],
            //'courseId',
            // 'chapterId',
            //'number',
            //'seq',
            [
                'attribute'=>'title',
                'format'=> 'raw',
                'value'=>function($m)
                {
                    $title = mb_substr($m->title , 0 ,12);
                    return "<span title='{$m['title']}'>{$title}</span>";
                }
            ],
           // 'title',
            //'summary:ntext',
            // 'tags:ntext',
           // 'type',
            [
                'attribute'=>'type',
                'filter'=>\common\utils\Constant::$CourseLessonType
            ],
            // 'content:ntext',
            // 'giveCredit',
            // 'requireCredit',
            // 'mediaId',
            'mediaSource',
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
            // 'free',
            // 'status',
            // 'mediaName',
            // 'mediaUri:ntext',
            // 'homeworkId',
            // 'exerciseId',
            // 'materialNum',
            // 'quizNum',
            // 'learnedNum',
            // 'viewedNum',
            // 'memberNum',
            // 'liveProvider',
            // 'userId',
            // 'createdTime',
            // 'testMode',
            // 'testStartTime:datetime',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>

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

<script>
    var  currentRowId = '';
    $( document ).on('click','.chooserCategoryBtn',function () {
        //console.log('click');
        currentRowId =  $(this).attr('data-id');
        console.log(currentRowId);
        $('#categoryModal').modal('show');
    });
//    $('.chooserCategoryBtn').click(function () {
//
//    });


    $('#save_category').click(
        function () {
        var  categorys = $('#select_category').children(':visible');
        var  categoryStr = '';
        for(var i=0 ; i<categorys.length ; i++)
        {
            categoryStr += categorys[i].value + ",";
        }
        categoryStr =  categoryStr.substr(0 ,categoryStr.length-1);
        $.ajax({
            url : '/lesson/change-category' ,
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

    $( document ).on('click','.chooserChapterBtn',function () {
        currentRowId =  $(this).attr('data-id');
        //console.log(currentRowId);
        $('#chapterModal').modal('show');
    });
//    $('.chooserChapterBtn').click(function () {
//        currentRowId =  $(this).attr('data-id');
//        //console.log(currentRowId);
//        $('#chapterModal').modal('show');
//    });

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
            url : '/lesson/change-chapter' ,
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