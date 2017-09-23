<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<!-- 提示:: 如果你的网站使用https, 将xiuxiu.js地址的请求协议改成https即可 -->
<script type="text/javascript">
    window.onload=function(){
        /*第1个参数是加载编辑器div容器，第2个参数是编辑器类型，第3个参数是div容器宽，第4个参数是div容器高*/
        xiuxiu.embedSWF("altContent",5,"600px","480px");
        //修改为您自己的图片上传接口
        xiuxiu.setUploadURL("http://web.upload.meitu.com/image_upload.php");
       // xiuxiu.setUploadURL("<?=$serverUrl?>");
        xiuxiu.setUploadType(2);
        xiuxiu.setUploadDataFieldName("upload_file");
        xiuxiu.onInit = function ()
        {
            xiuxiu.loadPhoto("<?=$avator?>");
        }
        xiuxiu.onUploadResponse = function (data)
        {
            //alert("上传响应" + data);  //可以开启调试
            var obj = JSON.parse(data);
            //console.log(obj);
            $("#"+'<?=$hiddenId?>').val( obj.original_pic );
            $("#"+'<?=$modelId?>').modal('hide');

            $("#"+ '<?=$repaceImageId?>').attr('src',obj.original_pic);
        }
    }
    function meitu_show() {
        $("#"+'<?=$modelId?>').modal('show');
    }
</script>
<button class="btn btn-sm btn-success" onclick="meitu_show()"> 修改头像</button>
<input type="hidden" id="<?=$hiddenId?>" name="<?=$name?>" value="<?=$avator?>">
<!-- 视频上传模态框（Modal） -->
<div class="modal fade" id="<?=$modelId?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 680px;height: 500px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn-close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" ><?=$modalTitle?></h4>
            </div>
            <div class="modal-body">
                <div id="altContent">
                    <h1>头像</h1>
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>


