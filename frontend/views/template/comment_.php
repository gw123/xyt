<style>
    .comment .item{ padding-top: 10px; padding-bottom: 20px; border-bottom: solid 1px #e9e3df;clear: both;
    }
    .col-xs-2 i{ width: 20px;margin-right: 10px;float: right}
</style>
<?php  if(!isset($type)) $type='article';if(!isset($id)) $id='1'; ?>
<script>
    var  commentType = '<?=$type?>';
    var  commentId   = '<?=$id?>';
</script>
<div class="panel panel-default comment">
    <div class="panel-heading">评论</div>
    <div class="panel-body">
        <div class="row item"  data-id="0">
            <div class="col-xs-1">  <img class="img-circle" src="/images/logo.jpeg"></div>
            <div class="col-xs-11 comment-input" style="padding: 0px">
                <div>
                    <textarea style="display: block" placeholder="写下您的评论..."> </textarea>
                    <button onclick="doReply(this)" class="textarea-btn" style="display: block">发表</button>
                </div>
            </div>
        </div>

        <div class="row item" data-id="124">
            <div class="col-xs-1">  <img class="img-circle" src="/images/logo.jpeg"></div>
            <div class="col-xs-11">
                <h5 > 刘辉2 1029 <small> 19小时</small> </h5>
                <p> 给你跟你哥一个超级赞，现在这样的亲情不多了，住你婚后幸福，也祝愿你哥身体能越来越好 </p>
                <div class="row">
                    <a class="col-xs-10" onclick="reply(this)"> 回复 </a>
                    <a class="col-xs-2">  <i class="glyphicon glyphicon-thumbs-up"></i> <i class="glyphicon glyphicon-phone-alt"></i>  </a>
                </div>

                <div class="row item" data-id="123">
                    <div class="col-xs-1">  <img class="img-circle" src="/images/logo.jpeg"></div>
                    <div class="col-xs-11">
                        <h5 > 刘辉 1029 <small> 19小时</small> </h5>
                        <p> 给你跟你哥一个超级赞，现在这样的亲情不多了，住你婚后幸福，也祝愿你哥身体能越来越好 </p>
                        <div class="row">
                            <a class="col-xs-10" onclick="reply(this)"> 回复 </a>
                            <a class="col-xs-2">  <i class="glyphicon glyphicon-thumbs-up"></i> <i class="glyphicon glyphicon-phone-alt"></i>  </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row item" data-id="23">
            <div class="col-xs-1">  <img class="img-circle" src="/images/logo.jpeg"></div>
            <div class="col-xs-11">
                <h5 > 刘辉 1029 <small> 19小时</small> </h5>
                <p> 给你跟你哥一个超级赞，现在这样的亲情不多了，住你婚后幸福，也祝愿你哥身体能越来越好给你跟你哥一个超级赞，现在这样的亲情不多了，住你婚后幸福，也祝愿你哥身体能越来越好给你跟你哥一个超级赞，现在这样的亲情不多了，住你婚后幸福，也祝愿你哥身体能越来越好 </p>
                <div class="row">
                    <a class="col-xs-10" onclick="reply(this)"> 回复 </a>
                    <a class="col-xs-2">  <i class="glyphicon glyphicon-thumbs-up"></i> <i class="glyphicon glyphicon-phone-alt"></i>  </a>
                </div>
            </div>
        </div>

    </div>
</div>

<script>



function reply(ele) {
    $('.sub-comment').remove();
    var  str=
      '<div class="col-xs-12 comment-input item sub-comment" style="padding: 0px">\
        <textarea style="display: block" placeholder="写下您的评论..."> </textarea>\
        <button class="textarea-btn" style="display: block" onclick="doReply(this)">发表</button>\
      </div>';
    $(str).insertAfter($(ele).parent());
}

function doReply(ele) {
    //console.log( $(ele).parent().parent().parent().attr('data-id'))
    var  parentid = $(ele).parent().parent().parent().attr('data-id')
    var  content = $(ele).prev().val();
    console.log( parentid ,content)
    doRequest(commentType ,commentId,content,parentid);
}

function doRequest(type ,toid ,content, parentId) {
    if(content.length>1024) { alert('评论内容超过1024字节！'); return;}
    var data = {
        '_csrf-frontend' : _csrf_token,
        type :type,
        toId : toid,
        content:content,
        parentId:parentId
    }
   $.ajax({
       url:'/user/comment',
       method:'post',
       data:data,
       success:function (response) {
           if(response.status==1)
           {
                window.location.reload();
           }else{
               alert(response.msg);
           }
       }
   })
}

</script>