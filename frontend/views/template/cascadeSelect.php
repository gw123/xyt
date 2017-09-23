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

<div class="form-group field-article-point">
    <?php
    if(!$model->chapter)  $model->chapter = Yii::$app->request->get('chapter');
    $chapters = \common\models\ChapterSearch::getTitlesByIdstr($model->chapter);
    $chapterStr =  implode(' >> ' , $chapters);
    echo Html::label('章节 ： ' , ['class'=>'control-label']);
    echo Html::button($chapterStr?$chapterStr:'点击选择',['class'=>'btn btn-default chooserChapterBtn' ]);
    echo Html::input('hidden','Article[chapter]',$model->chapter);
    ?>
</div>

<script>
    $('.chooserChapterBtn').click(function () {
        currentRowId =  $(this).attr('data-id');
        $('#chapterModal').modal('show');
    });

    $('#save_chapter').click(function () {
        var  selectors = $('#select_chapter').children(':visible');
        var  chapteridStr = '' ,chapterStr='' ;
        for(var i=0 ; i<selectors.length ; i++)
        {
            if( selectors[i].value==0)  break;
            chapteridStr += selectors[i].value + ",";
            var index = selectors[i].selectedIndex; // 选中索引
            chapterStr +=  selectors[i].options[index].text + ">>";
        }
        chapteridStr =  chapteridStr.substr(0 ,chapteridStr.length-1);
        chapterStr =  chapterStr.substr(0 ,chapterStr.length-2);
        $("[name='Article[chapter]']").val(chapteridStr);
        $(".chooserChapterBtn").text(chapterStr?chapterStr:'点击选择');
        $('#chapterModal').modal('hide');
// console.log(chapterStr);
// 修改条数据的章节信息
    });

    var lvl_chapter = <?=json_encode(\common\models\Chapter::getLvl1Chapter())?>;
    //初始化章节数据
    var chapterconfig = {
        'firstData' :lvl_chapter,
        'selector'  : "#select_chapter",
        'serverUrl' : '/chapter/get-chapter-sons',
    };
    CascadeSelect(chapterconfig);
</script>
