<style xmlns="http://www.w3.org/1999/html">
    .comment .item{ padding-top: 10px; padding-bottom: 20px; border-bottom: solid 1px #e9e3df;clear: both;
    }
    .user-head{ max-width: 80px;}
    .user-head img{ max-width: 50px;}
    .comment .item:last-child{ border-bottom: none}
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
            <div class="col-xs-2 col-md-1 user-head">  <img class="img-circle" src="/images/logo.jpeg"></div>
            <div class="col-xs-10  col-md-11 comment-input" style="padding: 0px">
                <div>
                    <textarea style="display: block" placeholder="写下您的评论..."></textarea>
                    <button onclick="doReply(this)" class="textarea-btn" style="display: block">发表</button>
                </div>
            </div>
        </div>
        <?php foreach ($comments as $comment){  ?>
            <div class="row item" data-id="<?=$comment['id']?>">
                <div class="col-xs-2 col-md-1 user-head"> <a href="/user/index?uid=<?=$comment['userId']?>"> <img class="img-circle" src="<?=$comment['avatar']?>"> </a> </div>
                <div class="col-xs-10  col-md-11">
                    <h5 > <?=$comment['nickname']?> <small> <?=$comment['createdTime']?> </small> </h5>
                    <p> <?=$comment['content']?>  </p>
                    <div class="row">
                        <a class="col-xs-10" onclick="reply(this)"> 回复 </a>
                        <a class="col-xs-2">  <i class="glyphicon glyphicon-thumbs-up"></i> <i class="glyphicon glyphicon-phone-alt"></i>  </a>
                    </div>

                    <?php  if(isset($comment['children'])){
                            foreach ($comment['children'] as $child){
                    ?>
                        <div class="row item" data-id="<?=$child['id']?>">
                            <div class="col-xs-2 col-md-1 user-head">  <a href="/user/index?uid=<?=$comment['userId']?>"><img class="img-circle" src="<?=$comment['avatar']?>"></a></div>
                            <div class="col-xs-10  col-md-11">
                                <h5 ><?=$child['nickname']?>  <small> <?=$child['createdTime']?></small> </h5>
                                <p> <?=$child['content']?> </p>
                                <div class="row">
                                    <a class="col-xs-10" onclick="reply(this)"> 回复 </a>
                                    <a class="col-xs-2">  <i class="glyphicon glyphicon-thumbs-up"></i> <i class="glyphicon glyphicon-phone-alt"></i>  </a>
                                </div>
                            </div>
                        </div>
                    <?php } }?>

                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>



function reply(ele) {
    $('.sub-comment').remove();
    var  str=
      '<div class="col-xs-12 comment-input item sub-comment" style="padding: 0px">\
        <textarea style="display: block" placeholder="写下您的评论..."></textarea>\
        <button class="textarea-btn" style="display: block" onclick="doReply(this)">发表</button>\
      </div>';
    $(str).insertAfter($(ele).parent());
}

function doReply(ele) {
    //console.log( $(ele).parent().parent().parent().attr('data-id'))
    var  parentid = $(ele).parent().parent().parent().attr('data-id')
    var  content = $(ele).prev().val();
    //console.log( parentid ,content)
    doRequest(commentType ,commentId,content,parentid);
}

function doRequest(type ,toid ,content, parentId) {
    if(content.length>1024) { alert('评论内容超过1024字节！'); return;}
    if(content.length<=0) { alert('请填写评论内容！'); return;}
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
           console.log(response)
           if(response.status==1)
           {
                window.location.reload();
           }else if(response.status==5){
                alert("请登录");
                window.open('/site/login')
           }else{
               alert(response.msg);
           }
       }
   })
}

</script>