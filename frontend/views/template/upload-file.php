<?php
  use yii\helpers\Html;
  $modelId =  md5(time().$name);
?>
<!-- 文件上传地址 -->
<?= Html::label($lableTitle.' <small style="font-weight: 400"> (上传或者网络地址 文件大于100m 请联系管理员上传)</small>: ' , ['class'=>'control-label']);?>
<div class="row">
    <div class="col-sm-9">
        <?= Html::input('text',$name,  $model[$field]? $model[$field] :'',['class'=>'form-control' ]); ?>
    </div>
    <div class="col-sm-3">
        <?= Html::input('text','',$modalTitle,[ 'id'=>'btn_show_'.$modelId , 'class'=>'btn btn-default form-control' ]); ?>
    </div>
    <?php
    $errors = $model->getErrors($field);
    if(!empty($errors))  { echo   "<div class='col-sm-12 has-error'> <span class='help-block'>".$errors[0]." </span></div>" ; };
    ?>
</div>
<!-- 视频上传模态框（Modal） -->
<div class="modal fade" id="<?=$modelId?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div class="row" style="margin-bottom: 10px;">
                        <div class="col-md-8 "> <input type="file"    class="upload_file_input btn btn-success" style="width: 100%"  > </div>
                        <div class="col-md-4 "> <input type="button"  class="form-control btn-on-upload"  value="上传"> </div>
                </div>

                <div class="row upfile_progress"  style="display:none;margin-top: 5px;">
                    <div class="col-sm-12 ">
                        <div class=" progress progress-striped active">
                          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                        </div>
                    </div>
                </div>

                <row style="" class="display">
                    <?php if($fileType=='image'){ ?>
                    <div class="upload_display_wrap" style="min-height:100px;padding:40px;text-align:center;font-size:2em;border: dashed">
                        <img class="upload_dispaly" src="<?=$model[$field]?>"  alt="图片无法显示"></div>
                    <?php } else if($fileType=='video') {?>
                        <video width="320" height="240" controls class="video">
                            <source class="upload_dispaly" src="<?=$model[$field]?>" type="video/mp4">
                            <object data="movie.mp4" width="320" height="240">
                                <embed width="320" height="240" class="upload_dispaly" src="<?=$model[$field]?>">
                            </object>
                        </video>
                    <?php } ?>
                </row>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-close" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-on-save"   > 保存</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>

    var file_type<?=$modelId?> = '<?=$fileType?>'; //文件类型
    $("#"+'btn_show_<?=$modelId?>').click(function () {
        console.log('btn_show');
        $("#"+'<?=$modelId?>').modal('show');
    });
    var url_<?=$modelId?> = '';            //寄存变量
    $("#"+'<?=$modelId?>').find('.btn-on-save').click(function () {
        if(url_<?=$modelId?>)
        {
            $("[name='<?=$name?>']").val( url_<?=$modelId?> );
        }
        $("#"+'<?=$modelId?>').modal( 'hide' );
    });

    $("#"+'<?=$modelId?>').find('.btn-on-upload').click(function () {
        console.log('btn-on-upload');
        var uploader =  $("#"+'<?=$modelId?>');
        //上传进度
        function onProgress(evt) {
            var loaded = evt.loaded;     //已经上传大小情况
            var tot    = evt.total;      //附件总大小
            var per    = Math.floor(100*loaded/tot);  //已经上传的百分比
            // console.log(per);
            uploader.find(".progress-bar").css("width" , per +"%");
        }
        var _this = this;
        uploader.find('.upfile_progress').show();
        //console.log( uploader.find('.upload_file_input') );
        var file =  uploader.find('.upload_file_input')[0].files[0];
        //var localUrl= window.URL.createObjectURL(file)
        //显示
        //uploader.find('.upload_dispaly').prop('src',localUrl)
        var formData  = new FormData();
        formData.append('file',file);

        $.ajax({
            type: "POST",
            url: '<?=$serverUrl?>' ,//"/uploader/upload-video",
            data: formData ,　　//这里上传的数据使用了formData 对象
            processData : false,
            contentType : false ,  //必须false才会自动加上正确的Content-Type
            //这里我们先拿到jQuery产生的 XMLHttpRequest对象，为其增加 progress 事件绑定，然后再返回交给ajax使用
            xhr: function(){
                var xhr = $.ajaxSettings.xhr();
                if( onProgress && xhr.upload) {
                    xhr.upload.addEventListener("progress" , onProgress , false);
                    return xhr;
                }
            },
            dataType:'json',
            success:function (response) {
               // console.log(response);
                url_<?=$modelId?>  = response.url;
                if(file_type<?=$modelId?> == 'image')
                {
                    uploader.find(".upload_dispaly").attr('src',response.url);
                }else if(file_type<?=$modelId?> =='video')
                {
                    uploader.find(".upload_dispaly").attr('src',response.url);
                    var outer = uploader.find(".display").html();
                    //console.log(outer)
                    uploader.find(".display").empty();
                    uploader.find(".display").append(outer);
                    //uploader.find(".video").show();
                }
            },
            //error:function ( a1 ) {   console.log( a1) ; errorTip(al);}
        });

    });

</script>
