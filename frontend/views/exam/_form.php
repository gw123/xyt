<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Exam */
/* @var $form yii\widgets\ActiveForm */
?>
<style>
    .padding_0{
        padding: 0px;
    }
    #chapter_show span{ margin-left:4px; padding: 5px;4px; color: #3e3e3e; border-bottom: solid 1px #000000 }
</style>

<script src="/js/lib/select2/select2.full.js"></script>
<script src="/js/lib/select2/select2-krajee.js"></script>

<script type="application/javascript" >
    window.onload = function ()
    {
        var  chapterTree  = <?= $chapterTree ?> ;

        //通过id 查找节点
        var   stack = []; // 记录节点的父节点
        function  findNode(tree , id,lvl) {
            lvl==undefined ?lvl=1:'';
            if(lvl==1)  stack = [];
            //console.log(lvl);
            if(lvl==5)  return false;
            var ret;
            for(var i in tree)
            {
                if(tree[i]['id']==id)
                {
                    stack.push(tree[i]);
                    return tree[i];
                }
                else
                 {
                     ret= findNode(tree[i]['children'],id,++lvl);
                     if(ret)
                     {
                         stack.push(tree[i]);
                         return ret;
                     }

                 }
            }
            return false;
        }
        //
        function  updateChildren() {
            var id = $(this).attr('data-id');
            //console.log(id);
            var node = findNode(chapterTree,id)['children'];
            console.log(node);
            for(var i in node){
                var template = '<div class="col-sm-3" data-id='+node[i]['id']+'>'
                    +node[i]['name']+'</div>';
                $('.cascade').after(template);
                $('[data-id="'+node[i]['id']+'"]').click(updateChildren);
            }
            //$(this).append()
        }

        function  fromatSelectData(nodes) {
            var tempArr = [];
            tempArr.push({id:0,text:'选择'});
            for(var i in nodes)
            {
                tempArr.push({id:nodes[i]['id'],text:nodes[i]['name']});
            }
            return tempArr;
        }

        var tempArr = fromatSelectData(chapterTree);
            $('#select_1').select2({
            data:tempArr
        });

        var template =
           ' <div class="col-sm-2 padding_0">'+
           '<div class="form-control" >'+
           '<select id="{0}" lvl="{1}" name="chapter_[{1}]" class="select2" style="min-width: 120px">'+
           '</select>'+
           '</div>'+
           '</div>';

        $('#select_1').change(function () {
            var value = $(this).val();
            $("#chapter").val(value);
            $(this).parent().parent().nextAll().remove();

            var node =findNode(chapterTree ,value);
            var tempArr = fromatSelectData(node['children']);
            //console.log(value);
            var lvl =  $(this).attr('lvl');
            lvl++;
            var id = 'select_'+lvl;
            var tp = sprintf(template,id ,lvl);
            $('.cascade').append(tp);
           // console.log("#"+id);
            $('#'+id).select2({
                data:tempArr
            });
            $('#'+id).change(selectChange);

        });
        function  selectChange() {
            var value = $(this).val();
            $("#chapter").val(value);
            var node =findNode(chapterTree ,value);

            $('#chapter_show').empty();
             while (stack.length)
             {
                 var parent = stack.pop();
                 $('#chapter_show').append("<span>"+parent.name+"</span>");
             }

            $(this).parent().parent().nextAll().remove();
            if(node['children']==undefined) return;
            var tempArr = fromatSelectData(node['children']);
            //console.log(value);
            var lvl =  $(this).attr('lvl');
            lvl++;
            //console.log(lvl);
           ;var id = 'select_'+lvl;
            var tp = sprintf(template,id,lvl);
            $('.cascade').append(tp);
            $('#'+id).select2({data:tempArr});
            $('#'+id).change(selectChange);
        }
    }

</script>

<div class="exam-form">

    <?php $form = ActiveForm::begin([
         'method' => 'post',
         'options' => ['class' => 'form-horizontal'],
      ]);?>

    <div class="form-group cascade " >
        <label class=" col-sm-12 padding_0"> 章节选择  </label>
        <div class="col-sm-4 padding_0 control-lable" id="chapter_show">

        </div>
        <div class="col-sm-2 padding_0">
            <div class=" form-control" >
                <select  id="select_1" lvl="1" class="" style="min-width: 80px" name="chapter_[1]">
                </select>
            </div>
        </div>
    </div>

    <div style="display: none"><?= $form->field($model, 'chapter')->hiddenInput([
            'id' => 'chapter',]) ?> </div>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'intro')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'cover')->textInput(['maxlength' => true]) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<div style="display:none" >
    <?php echo Select2::widget(['name' => 'state_2',]); ?>
</div>
