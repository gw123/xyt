<?php
  if(!isset($name)) $name = 'cover';
  $_name= preg_replace('/[\[\]\,\'\"]/','',$name);
  if(!isset($widgetId))  $widgetId = 'cropit_'.$_name;
  $widgetPreview = $widgetId."_preview";
  if(!isset($imageUrl))  $imageUrl = '';
  if(!isset($height)) $height='200';
  if(!isset($width))  $width ='300';
?>

<script src="/js/jquery.cropit.js"></script>
<style>
    .cropit-editor{  position:relative; padding: 10px;}
    .cropit-upload-icon{ position: absolute; top: 22px;right: 20px;
        border: 1px solid rgba(229, 229, 229, 0.25);
        height: 30px;  width: 30px;z-index: 1200;
        background-position-x: 120px;
        background-image:url('/images/icons/cropperIcons.png') }
    .cropit-preview {
        background-color: #f8f8f8;
        background-size: cover;
        border: 1px solid #ccc;
        border-radius: 3px;
        margin-top: 7px;
        margin-bottom: 10px;
        width:<?=$width?>px;
        height:<?=$height?>px;
    }
    .cropit-preview-background {  opacity: 0.2;  }
    .cropit-preview-image-container {  cursor: move;  }
    .image-size-label {  margin-top: 10px;  }
    input[type='range']{ width: 60% ;outline: none; -moz-outline-style: none; }
    input[type='range']:focus{ outline: none; -moz-outline-style: none; }
    .export {
        background-color: #e0e2e3;;  border:1px solid #dadada;
        width: 20%;
        float: right;
    }

</style>


<div class="row">
    <div class="col-sm-12">
        <label>封面图片</label>
    </div>
</div>

<div class="row" >

        <div class="col-sm-6">
            <div id='<?=$widgetId?>' class="cropit-editor">
                <input class="hidden" type="hidden" name="<?=$name?>" value="<?=$imageUrl?>">
                <input type="file"   class="cropit-image-input" style="display: none">
                <span class="cropit-upload-icon"> </span>
                <div class="cropit-preview">
                    <center style="margin-top: 60px;"><h3>点击选择你要上传的图片 </h3>
                        <small>点击图片，按住鼠标左键可以移动图片<br>(上传图片的尺寸大于<?=$width?>*<?=$height?>)</small>
                    </center>
                </div>
                <div class="" style="position: relative; z-index: 1000">
                    <span>- </span>
                    <input type="range" class="cropit-image-zoom-input">
                    <span> +</span>
                    <!--    <button class="rotate-cw">顺时针旋转</button>-->
                    <button class="export" type="button">剪切</button>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <label> 预览 </label>
            <div id='<?=$widgetPreview?>'class="cropit-preview" >
                <img src="" style="width: <?=$width?>px;height: <?=$height?>px">
            </div>
        </div>
</div>


<script>

    $(function() {

        $('.cropit-image-input').click(function () {
            $('.cropit-image-zoom-input').val(0)
        })

        $('.cropit-upload-icon').click(function () {
            $('.cropit-image-input').click();
        })

        $('#<?=$widgetPreview?> img').attr('src' ,'<?=$imageUrl?>');
        $('.cropit-editor').cropit({
            imageBackground: true,
            imageState: {
                //src: '<?=$imageUrl?>',
            },
        });

        $('.rotate-cw').click(function() {
            $('.cropit-editor').cropit('rotateCW');
        });

        $('.export').click(function() {
            var imageData = $('.cropit-editor').cropit('export');
            //var imageData = 'data:image/png;base64,';
            imageData = imageData.substr(22)
            $.ajax({
                url : '/article/upload?action=uploadscrawl',
                type:'post',
                data :{ upfile:imageData },
                success:function (response) {
                    if(response&&response.state)
                    {
                        url = response.url;
                        $('#<?=$widgetId?> .hidden').val(url);
                        $('#<?=$widgetPreview?> img').attr('src' ,url);
                        console.log(url)
                    }else{

                    }
                },
                error:function (e) {
                    console.log(e)
                }

            })

            //window.open(imageData);
        });
    });
</script>


