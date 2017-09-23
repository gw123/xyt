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
        showRenameBtn: false,
        //removeTitle:'删除',
        //renameTitle:'重命名'
    },
    data: {
        simpleData: {
            enable: true
        }
    },
    callback: {
        onClick: zTreeOnClick,
        //onDrag: zTreeOnDrag,
        onDrop: zTreeOnDrop
        //beforeEditName: beforeEditName,
        //beforeDrag: beforeDrag,
        //beforeDrop: beforeDrop
    }
};

function zTreeOnClick(event,treeid,treeNode,clikFlag) {
    _currentTreeNode = treeNode
    console.log(_currentTreeNode);
    $('[name="item_name"]').val(treeNode.name);
    $('[name="item_id"]').val(treeNode.id);
    $('[name="item_parent"]').val(treeNode.parentid);
    $("[name='item_root']").val(treeNode.root);

    $('.node-title h4').text( treeNode.name );
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

//更新节点
function btn_save() {
    //console.log(_currentTreeNode);
    if(!_currentTreeNode) { errorTip('请选择节点!!'); return ;}
    var name = $('[name="item_name"]').val();
    console.log(name);
    ChapterService.updateNode(function (response) {
        if(response.status) {
            _currentTreeNode.name = name;
            chapterTree.updateNode(_currentTreeNode);
            layer.msg('更新成功');
        }
        else{ alert(response.msg); }
    } ,{id:_currentTreeNode.id ,title:name} );
}

//删除
function btn_del() {
    var data ={id:_currentTreeNode.id, root:_currentTreeNode.root };
    TagService.deleteTagNode(function (response) {
        console.log(response);
        if(response.status=="1")
        {
            succesTip();
            chapterTree.removeNode(_currentTreeNode);
        }else{
            errorTip();
        }
    },data);
}

$(document).ready(function(){

    //窗口大小调整  尺寸调整
    window.onresize = function () {
        if (window.innerHeight)
            winHeight = window.innerHeight;
        else if ((document.body) && (document.body.clientHeight))
            winHeight = document.body.clientHeight;
        //console.log(winHeight);
        winHeight = winHeight - 111; // 减去顶部和底部的高度
        $('.main-content').height(winHeight)
        //console.log( $('.main-content').height() );
        var headerHeight = $('.node-tile').height();
        var headerHeight1 = $('.navbar').height();
        $('.main-content .content .content-page').height(winHeight - headerHeight-headerHeight1-150);
       var height = $(".left-tree-nav").height();
        $("#treeMap").height(winHeight-205);
    }

    window.onresize();
    console.log(treeMap );
    //获取树形菜单
    chapterTree = $.fn.zTree.init($("#treeMap"), setting , treeMap[0]);

    /************************** 菜单导航部分*********************/
    /********************* 执行指定的动作 ***********************/
    $('.dropdown li a').click(function () {
        if(!_currentTreeNode) { $.waring('请在左侧选择你要操作的节点!!');return ; }
        var  target  = $(this).attr('data-target');
        console.log(target);
        switch (target)
        {
            case 'page_article_list' :
                ArticleService.getArticleListByChapter(function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }

                    var tpl_list =
                        ' <li class="box" ><a target="_blank" href="/article/view?id={id}">{title} </a>  </li>';
                    updateListTemplate( {
                        template:tpl_list,
                        keys:['id','title'],
                        element:'#article_list',
                        data: response.data,
                     });
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;

            case 'page_video_list' :
                VideoService.getVideoListByChapter(function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }

                    var tpl_list =
                        ' <li class="box" ><a target="_blank" href="/video/view?id={id}">{title} </a>  </li>';
                    updateListTemplate( {
                        template:tpl_list,
                        keys:['id','title'],
                        element:'#video_list',
                        data: response.data,
                    });
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;
            case 'page_paper_list' :
                PaperService.getPaperListByChapter( function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }

                    var  tpl_exam_list ='<li >\
                        <div class="li-image"><img src="/image/exam/exam_1.png"></div>\
                        <div class="li-content">\
                        <div class="list-title">{title}\
                        <a href="'+eduHost+'/lesson/{lessonId}/test/{tId}/do" target="_blank" title="在开始答题前请先加入改试卷所在课程。"><span class="badge">开始测试</span> </a> </div>\
                        <small class="list-desc"> 所属课程:<a href="'+eduHost+'/course/{courseId}" target="_blank">{courseTitle} </small>\
                        </div>\
                        <div style="clear: both"></div>\
                        </li>';
                    updateListTemplate( {
                        template: tpl_exam_list ,
                        keys:['lessonId','title','tId','intro','courseId','courseTitle'],
                        element:'#paper_list',
                        data: response.data,
                        callback:null,
                    } );
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;
            case 'page_answer_list' :
                AnswerService.getAnswerListByChapter(function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }

                    var tpl_list =
                        ' <li class="box" ><a target="_blank" href="/answer/view?id={id}">{title} </a>  </li>';
                    updateListTemplate( {
                        template:tpl_list,
                        keys:['id','title'],
                        element:'#answer_list',
                        data: response.data,
                    });
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;
            case 'page_point_list' :
               PointService.getPointListByChapter(function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }
                    var tpl_list =
                        ' <li class="box" ><a target="_blank" href="/point/view?id={id}">{title} </a>  </li>';
                    updateListTemplate( {
                        template:tpl_list,
                        keys:['id','title'],
                        element:'#point_list',
                        data: response.data,
                    });
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;
            case 'page_material_list' :
                MaterialService.getMateriaListByChapter(function (response) {
                    if(response.status!=1) { alert('未返回数据'); return; }
                    var tpl_list =
                        ' <li class="box" ><a target="_blank" href="/material/view?id={id}">{title} </a>  </li>';
                    updateListTemplate( {
                        template:tpl_list,
                        keys:['id','title'],
                        element:'#material_list',
                        data: response.data,
                    });
                },{ chapterId : _currentTreeNode.id } );

                $('.content-page').hide();
                $('#'+target).show();
                break;
            case 'article_create' :
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
            case 'point_create' :
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
            case 'material_create' :
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

            case 'material_chapter_pdf' :
                var  chapterIds = [];
                var node = _currentTreeNode;
                while (node)
                {
                    chapterIds.push(node.id);   node = node.getParentNode()
                }
                chapterIds.reverse();
                var chapterStr = chapterIds.join(',');
                window.open('/material/create?chapterpdf=1&chapter='+chapterStr);
                break;

            case 'answer_create' :
                var  chapterIds = [];
                var node = _currentTreeNode;
                while (node)
                {
                    chapterIds.push(node.id);   node = node.getParentNode()
                }
                chapterIds.reverse();
                var chapterStr = chapterIds.join(',');
                window.open('/answer/create?chapter='+chapterStr );
                break;
            case 'paper_create' :
                var  chapterIds = [];
                var node = _currentTreeNode;
                while (node)
                {
                    chapterIds.push(node.id);   node = node.getParentNode()
                }
                chapterIds.reverse();
                var chapterStr = chapterIds.join(',');
                window.open('/paper/create?chapter='+chapterStr );
                break;
            case 'video_create' :
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
            case 'page_import_chapter':
                $('#page_import_chapter').show();
                break;
            case 'page_import_pages':
                $('#page_import_pages').show();
                break;
            default:
                console.log( 'action: '+target + ' do not exist!! ');
        }
    });
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






