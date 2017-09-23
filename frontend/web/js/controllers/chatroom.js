/**************************** 聊天室******************/
//消息类型
//消息类型
//消息类型
const MsgType = {
    'checkToken': 1,
    'msg': 2,
    'close': 3,
    'info': 4,
    'error': 5,
    'waring': 6,
    'updateToken': 7,
    'initData':8 ,
    'joinGroup':9,
    'userOnline':10,
    'userOffLine':11,
}

//消息组
var chatGroup  = [];

function  Chat(server,callback) {
    this.server = server;
    this.isInit = false;
    this.ws = null;
    var _this =this;
    this.token = currentUser.auth_key;
    var ue = UE.getEditor('post_editor',{
        toolbars: [
            [  'undo', 'redo', 'bold']
        ],
        serverUrl:'/uploader/ue',
        autoHeightEnabled:false
    })
    //初始化
    this.connect = function () {
        this.ws = new WebSocket(this.server);
        _this =this;
        this.ws.onopen = function(){
            console.log("握手成功");
            _this.isInit = true;
            //验证身份

            _this.send(  MsgType.checkToken ,{token:_this.token}  );
        }

        //发消息
        $('#btn_send_msg').click(function () {
            var msg= ue.getContent();
            console.log(msg);
            _this.send( MsgType.msg ,{'groupId': 1 ,'msg':msg ,token:_this.token} );
        });
        //发消息
        $('.room_list li').click(function () {
            var groupId = $(this).attr('data-groupid');
            _this.send(MsgType.joinGroup ,{ 'groupId': groupId,token:_this.token } );
        });

        this.ws.onmessage =this.onmessage;

        this.ws.onerror = function(){
            console.log("error");
        }
    }

    /****
     *  发送
     * @param centent  消息内容
     * @param type         消息类型 警告 错误。。。
     * @param group     消息分组  可进修对比炒作
     */
    this.send=  function ( type , content ) {
        var  data = {};
        if(type==undefined||content==undefined)
        {
            alert('发送消息格式有误'); return;
        }
        data.type=type;
        data.data = content;
        _this.ws.send( JSON.stringify( data) );
    }

    //解析从服务发送过来的消息
    this.parse = function(frame) {
        var frame = JSON.parse(frame);
        console.log('receive ',frame);
        if( frame.type == undefined)
        {
            console.log('数据有误');
            return false;
        }
        switch (frame.type)
        {
            case MsgType.initData :
                console.log('initData');
                if(frame.data.user)
                {
                    onlineUserlist = frame.data.onlineUserlist;
                    groupList  = frame.data.groupList;
                    for (var i in onlineUserlist)
                    {
                        var  str =
                            '<li><span class="glyphicon glyphicon-user"></span> '+onlineUserlist[i].username+'</li>';
                        $('#user_list').append(str);
                    }
                    //console.log(groupList);
                    for (var i in groupList)
                    {
                        var  str =
                            '<li><span class="glyphicon glyphicon-tree-conifer " data-groupid="'+groupList[i].id+'"></span> '+groupList[i].groupName+'</li>';
                        $('#room_list').append(str);
                    }
                    console.log('Token check OK !! ');
                }else{
                    console.log('Token check faild !! ');
                }
                break;
            case MsgType.msg:
                console.log('frame');
                var  uid = frame.data.uid;
                var  msg = frame.data.msg;
                var  groupId =frame.data.groupId;
                var  tpl = '<li class="box" data-target="{0}"> <span>{1}:<span> {2} </li>';
                var s=tpl.format(uid , frame.data.username , msg);
                $(s).insertBefore( $('#post_list').children().first() );
                break;
            case MsgType.userOnline:
                var str ='<li data-uid="'+frame.data.uid+'"><span class="glyphicon glyphicon-user" ></span> '+frame.data.username+'</li>';
                $('#user_list').append(str);

                break;
            case MsgType.waring:

                break;
        }
    }

    //接收消息
    this.onmessage = function (event) {
        //console.log("message:" + event.data);
        _this.parse(event.data);
    }
}

var ServerURL= 'ws://127.0.0.1:4201';

var  chat = new Chat (ServerURL,function () {
});
chat.connect();
