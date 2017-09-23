/*************************************************************
 ************************** 树型菜单部分***********************
 * ***********************************************************
 */
var zNodes =[];
var _currentTreeNode = null;
var _currentHoverTreeNode = null;
var currentChapterId = 0;
var chapterTree= null;
var setting = {
    view: {
        showLine: false,
        addHoverDom: addHoverDom,
        removeHoverDom: removeHoverDom,
        selectedMulti: false
    },
    edit: {
        enable: true,
        showRemoveBtn: false,
        showRenameBtn: true,
        //removeTitle:'删除',
        //renameTitle:'重命名'
    },
    data: {
        simpleData: {enable: true}
    },
    callback: {
        onClick: zTreeOnClick,
        onDrop: zTreeOnDrop
        //beforeEditName: beforeEditName,
        //beforeDrag: beforeDrag,
        //beforeDrop: beforeDrop
    }
};

function addBtn(type) {
    if(!_currentTreeNode) { $.waring('请选择节点!!');return ; }
    switch (type)
    {
        case 'article' :
            var  chapterIds = [];
            var node = _currentTreeNode;
            while (node)
            {
                chapterIds.push(node.id);   node = node.getParentNode()
            }
            chapterIds.reverse();
            var chapterStr = chapterIds.join(',');
            window.open('/article/create?chapter='+chapterStr );
            break;
        case 'video' :
            var  chapterIds = [];
            var node = _currentTreeNode;
            while (node)
            {
                chapterIds.push(node.id);   node = node.getParentNode()
            }
            chapterIds.reverse();
            var chapterStr = chapterIds.join(',');
            window.open('/video/create?chapter='+chapterStr );
            break;
        case 'point' :
            var  chapterIds = [];
            var node = _currentTreeNode;
            while (node)
            {
                chapterIds.push(node.id);  node = node.getParentNode()
            }
            chapterIds.reverse();
            var chapterStr = chapterIds.join(',');
            window.open('/point/create?chapter='+chapterStr );
            break;
        case 'material' :
            var  chapterIds = [];
            var node = _currentTreeNode;
            while (node)
            {
                chapterIds.push(node.id);   node = node.getParentNode()
            }
            chapterIds.reverse();
            var chapterStr = chapterIds.join(',');
            window.open('/material/create?chapter='+chapterStr );
            break;
    }
}

function zTreeOnClick(event,treeid,treeNode,clikFlag) {
    _currentTreeNode = treeNode
    console.log(_currentTreeNode);
    $.ajax({
        url: '/book/chapter-data',
        data:{chapterId :_currentTreeNode.id ,'_csrf-frontend':_csrf_token},
        dataType : 'json',
        type:'post',
        success:function ( response ) {
            if(response&&response.status==1)
            {
                reDrawPage(response.data);
            }else{
                $.waring(response.msg);
            }
        }
    });
}

function reDrawPage(pageData) {

    //初始化文章列表内容
    if(pageData.pointList){
        updateListTemplate( {
            template:'<li><a href="/video/view?id={id}"> {title} </a></li>',
            keys:['id','title'],
            element:'#tab_point ul',
            data: pageData.pointList,
            callback:function () {},
        } );
    }

    //视屏列表
    if(pageData.videoList)
    {
        updateListTemplate( {
            template:'<li><a href="/video/view?id={id}"> {title} </a></li>',
            keys:['id','title'],
            element:'#tab_video ul',
            data: pageData.videoList,
            callback:function () {},
        } );
    }

    //console.log(pageData.materialList)
    if(pageData.materialList)
    {
        updateListTemplate( {
            template:'<li><a href="/video/view?id={id}"> {title} </a></li>',
            keys:['id','title'],
            element:'#tab_video ul',
            data: pageData.materialList,
            callback:function () {},
        } );
    }

    if(pageData.articleList)
    {
        updateListTemplate( {
            template:'<li><a href="/article/view?id={id}"> {title} </a></li>',
            keys:['id','title'],
            element:'#tab_article ul',
            data: pageData.articleList,
            callback:function () {}
        });
    }
}

function beforeDrag(treeId, treeNodes) {
    for (var i=0,l=treeNodes.length; i<l; i++) {
        if (treeNodes[i].drag === false) {
            return false;
        }
    }
    return true;
}
function beforeDrop(treeId, treeNodes, targetNode, moveType) {
    return targetNode ? targetNode.drop !== false : true;
}

function zTreeOnDrop(event, treeId, treeNodes, targetNode, moveType) {

    for(var index in treeNodes)
    {
        var moveNode = treeNodes[index];
        var parentNode = targetNode;
        if( !parentNode )  { continue;}

        var param = {id:moveNode.id ,parentId:parentNode.id };
        ChapterService.moveNode(function (response) {
            if(response.status==1)
            { }else{
                alert('更新失败 '+response.msg+',请刷新页面');
            }
        }, param);
    }
};

function addHoverDom(treeId, treeNode) {
    //console.log('addHover')
    _currentHoverTreeNode = treeNode;
    var sObj = $("#" + treeNode.tId + "_span");
    if (treeNode.editNameFlag || $("#addBtn_"+treeNode.tId).length>0) return;
    var addStr = "<span class='button add' id='addBtn_" + treeNode.tId
        + "' title='add node' onfocus='this.blur();'></span>";
    sObj.after(addStr);

    var btn = $("#addBtn_"+treeNode.tId);
    if (!btn)  { alert('domError:'+btn); return;}

    // 添加新节点
    btn.bind("click", function(){
        if(!_currentHoverTreeNode) $.waring("请单击父节点");
        var data ={ name:'newNode',parentid:_currentHoverTreeNode.id,
            root: _currentHoverTreeNode.root,
            parents:_currentHoverTreeNode.parents};

        console.log(data);

        ChapterService.createChapterNode(function (response) {
            if(response.status==1)
            {
                data.id = response.data.id;
                data.parents = response.data.parents;
                //console.log(data);
                chapterTree.addNodes(treeNode, data );
            }
            return false;
        },data);
    });

};
function removeHoverDom(treeId, treeNode) {
    $("#addBtn_"+treeNode.tId).unbind().remove();
};

$(document).ready(function(){

    //获取树形菜单
    chapterTree = $.fn.zTree.init($("#treeMap"), setting , treeMap[0]);

    //导入章节
    $('#btn_import_chapter').click(function () {
        var content  =   $('#chapter_text').val();
        var pageOffset = $('#pageOffset').val();
        //console.log(content);
        $.ajax({
            url: '/chapter/import-chapter',
            type:'post',
            data:{ data:content , pageOffset :pageOffset ,'_csrf-frontend': _csrf_token ,'chapterRootId':chapterRootId},
            dataType:'json',
            success:function (response) {
                if(response.status)
                {
                    var msg = '导入成功<br>';
                    if(response.waring.length>0)
                    {
                        var  msg = msg+"警告:<br>"+ "<small style='line-height: 14px'>" + response.waring.join("<br>")+"</small>";
                        $.waring(msg);
                    }else{
                        $.waring('导入成功');
                    }
                }else{
                    $.error(response.msg);
                }
            },
            error: function () {
                $.error("网络错误哦 !");
            }
        });
    });

    //获取新教材列表
    $('[data-target="frame-chapter-list"]').click(function()
        {
            if(!_currentTreeNode) { $.waring('请选择节点!!');return ; }
            function  onResponse (response) {
                if(response.status==1)
                {
                    var  data = response.data;
                    var  param = response.param;
                    var  currentPage = param.currentPage;
                    var  total  = param.total;
                    var  pagesize = param.pagesize;

                    //点击文章列表触发事件 编辑文章
                    var makeCallback =function () {
                        return function(){
                            var  aid = $(this).attr('aid');
                            console.log(aid)
                            window.location.href="/chapter/index?root="+aid;
                        };
                    }

                    var config = {
                        template:"<li aid='{id}'><a >{name}</a></li>",
                        keys:['id','name'],
                        element:'#frame-chapter-list ul:first',
                        data: data,
                        callback:makeCallback(),
                    };
                    updateListTemplate( config );
                    //点击分页按钮触发事件
                    var _callback = function () {
                        var text = $(this).text().trim();
                        //console.log(text);
                        if(text=='«')
                        {
                            var  page = parseInt($(this).next().text())-1;
                            if(page<=0) return;
                        }else if(text=='»')
                        {
                            var  page = parseInt($(this).parent().children().first().next().next().text());
                            if(page<=0 || isNaN(page)) {$.waring('已经到底部'); return;}
                        }else{
                            var  page = parseInt($(this).text());
                        }
                        console.log(page);
                        ChapterService.getChapterList( onResponse ,{
                            pagesize:10,
                            page:page,
                            node_id:_currentTreeNode.id});
                    }
                    var  config = {
                        currentPage: currentPage,
                        sum:total,
                        pagesize:pagesize,
                        onclick:_callback,
                        container:"#frame-chapter-list .pagination",
                    };
                    pagination(config);
                }else{
                    $.waring('获取数据异常');
                }
                //  console.log(response);
            }

            ChapterService.getRootChapterByTag( onResponse ,{tag:_currentTreeNode.id});
        }
    );

});


// var videoServer = UploaderServer({btn_show:'#source_type_1',input_save_url:'#file_url' ,serverUrl:'/uploader/upload-video'});
// var imageServer =UploaderServer({btn_show:'#cover_url', input_save_url:'#cover_url' ,serverUrl:'/uploader/upload-image'});






