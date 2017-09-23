<script src="http://open.web.meitu.com/sources/xiuxiu.js" type="text/javascript"></script>
<script type="text/javascript">
    xiuxiu.setLaunchVars("nav", "/edit");
    xiuxiu.setLaunchVars("cropPresets", "3:5");
    xiuxiu.embedSWF("altContent2", 1, 600, 500, "lite");

    xiuxiu.onInit = function (id)
    {
        xiuxiu.loadPhoto("http://open.web.meitu.com/sources/images/1.jpg", false);
        xiuxiu.setUploadURL("http://web.upload.meitu.com/image_upload.php");
        xiuxiu.setUploadType(2);
        xiuxiu.setUploadDataFieldName("upload_file");
    }

    xiuxiu.onUploadResponse = function (data)
    {
        alert("上传响应" + data);
        //clearFlash();
    }

    xiuxiu.onDebug = function (data)
    {
        alert("错误响应" + data);
    }

    xiuxiu.onClose = function (id)
    {
        //alert(id + "关闭");
        clearFlash();
    }

    //清除flash
    function clearFlash()
    {
        document.getElementById("flashEditorOut").innerHTML='<div id="flashEditorContent"><p><a href="http://www.adobe.com/go/getflashplayer"><img alt="Get Adobe Flash player" src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"></a></p></div>';
    }

</script>

<div id="flashEditorOut">
<div id="altContent2">
    <h1>头像</h1>
</div>
</div>
