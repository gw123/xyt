<?php
  use yii\helpers\Html;
?>
<div class="form-group field-article-point">
    <?php
    if(!$model->category)  $model->category = Yii::$app->request->get('category');
    if(!$model->category)
    {   $chapterIds =  Yii::$app->request->get('chapter');
        if(!empty($chapterIds))
        $model->category = \common\models\Chapter::find()->select('category')->where("id in ({$chapterIds})")->asArray()->one()['category'];
    }
    $categorys = \common\models\CategorySearch::getTitlesByIdstr( $model->category );
    $categoryStr =  implode(' >> ' , $categorys);
    echo Html::label('目录 ： ' , ['class'=>'control-label']);
    echo Html::button($categoryStr?$categoryStr:'点击选择',['class'=>'btn btn-default chooserCategoryBtn form-control']);
    echo Html::input('hidden',$name ,$model->category );
    ?>
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
    $('.chooserCategoryBtn').click(function () {
        currentRowId =  $(this).attr('data-id'); //console.log(currentRowId);
        $('#categoryModal').modal('show');
    });

    $('#save_category').click(function () {

        var  selectors = $('#select_category').children(':visible');
        var  categoryidStr = '' ,categoryStr='' ;
        for(var i=0 ; i<selectors.length ; i++)
        {
            if( selectors[i].value==0)  break;
            categoryidStr += selectors[i].value + ",";
            var index = selectors[i].selectedIndex; // 选中索引
            categoryStr +=  selectors[i].options[index].text + ">>";
        }
        categoryidStr = categoryidStr.substr(0 ,categoryidStr.length-1);
        categoryStr =  categoryStr.substr(0 ,categoryStr.length-2);
        console.log(categoryStr);
        $("[name='<?=$name?>']").val(categoryidStr);
        $(".chooserCategoryBtn").text(categoryStr?categoryStr:"点击选择");
        $('#categoryModal').modal('hide');

    });

    var lvl_category = <?=json_encode(\common\models\CategorySearch::getLvl1CourseCategory())?>;
    //初始化目录数据
    var categoryconfig = {
        'firstData' :lvl_category,
        'selector'  : "#select_category",
        'serverUrl' : '/category/get-category-sons',
    };
    CascadeSelect(categoryconfig);
</script>