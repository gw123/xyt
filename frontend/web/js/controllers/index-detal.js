var setting = {
    view: {
        selectedMulti: false
    },
    check: {
        enable: false
    },
    data: {
        simpleData: {
            enable: true
        }
    },
    edit: {
        enable: false
    },
    callback:{
        onClick: tree_node_on_click
    }
};

/**
 *  点击节点
 * */
function  tree_node_on_click(event,treeid,treeNode,clikFlag) {
    _currentTreeNode = treeNode
    console.log(_currentTreeNode);
    _currentChapter = treeNode.id;
    $.ajax({
        url: '/index/get-chapter-detail',
        data:{id :_currentChapter ,'_csrf-frontend':_csrf_token},
        dataType : 'json',
        type:'post',
        success:function ( response ) {
            //console.log(response);
            var currentChapter = response.data.currentChapter;
            $('.current-pos-content').empty();
            for(var i in currentChapter.parents)
            {
                var id = currentChapter.parents[i].id;
                var title = currentChapter.parents[i].title;
                var str = "<a href='?id=" + id + "'>" + title + "</a> <small> >> </small> ";
                $('.current-pos-content').append(str);
            }
            reDrawPage(response.data);
        }
    });

}//end tree_node_on_click

function reDrawPage(pageData) {
    $('.lesson_right .title_').html(pageData.currentChapter.title);
    $('.lesson_right .info_').html( pageData.currentChapter.desc );
    //点击知识点回掉函数
    var pointListClickCallBack = function () {
        var id =  parseInt( $(this).attr('data-target') );
        console.log(id);
        PointService.getAriticleDetal( function (response) {
            console.log(response);
            var data = response.data;
            var date = new Date( data.createdTime *1000);
            // $("#page_point_detal .date").text(   date.format('yyyy-MM-dd') );
            // $("#page_point_detal .title").text(data.title);
            $("#page_point_detal .desc").html(data.desc);
            //$("#page_point_detal .content").html(data.content);
            var page =$("#page_point_detal").html();
            //页面层-自定义
            layer.open({
                type: 1,
                title: data.title,
                closeBtn: 2,
                area: ['700px', '530px'],
                shadeClose: true,
                skin: 'layui-layer-gw123',
                content: page
            });
        } ,{id:id});
    }
    //console.log(pageData.pointList);
    //初始化文章列表内容
    if(pageData.pointList){
        updateListTemplate( {
            template:'<li class="box" data-target="{id}"> {title} </li>',
            keys:['id','title'],
            element:'#point_list',
            data: pageData.pointList,
            callback:pointListClickCallBack,
        } );
    }

    //视屏列表
    if(pageData.videoList)
    {
        var data = {'chapter': currentChapter };
        var tpl_video_list = ' <li  data-target="{id}">\
             <p><img src="/image/video/video1.png"> </p>\
             <b>{title}</b>\
             </li>';
        updateListTemplate( {
            template:tpl_video_list,
            keys:['id','title','desc'],
            element:'#viode_list',
            data: pageData.videoList,
            callback:function () {
                var id =  parseInt( $(this).attr('data-target') );
                console.log(id);
                layer.open({title:'', type: 2,
                    area: ['840px', '640px'], fixed: false, //不固定
                    maxmin: true, content: '/video/player?id='+id
                });
            },
        } );
    }

    //console.log(pageData.materialList)
    if(pageData.materialList)
    {
        var template = ' <li class="box row" data-target="{id}">'+
            '<div class="col-md-3">' +
            '<span class="glyphicon glyphicon-file"></span>' +
            '<label>{title}</label>' +
            '</div>' +
            '<div class="col-md-4">{desc}</div>'+
            '<div class="col-md-5">'+
            '<b>下载量 <span>100</span></b> <b>上传时间 <span>{createdTime}</span></b>'+
            '<a href="{content}" target="_blank">下载 <span class="glyphicon glyphicon-download"></span></a>'+
            '</div>'+
            '</li>';

        updateListTemplate( {
            template:template,
            keys:['id','title','desc','content','createdTime'],
            element:'#material_list',
            data: pageData.materialList,
            callback:function () {},
        } );

        //获取该节点下面的资料
        var callback = function () {
            var id =  parseInt( $(this).attr('data-target') );
            console.log(id);
            MaterialService.getMaterialDetal( function (response) {
                console.log(response);
                var data = response.data;
                var date = new Date( data.create_time *1000);

                $("#page_material_detal .date").text(   date.format('yyyy-MM-dd') );
                $("#page_material_detal .title").text(data.title);
                $("#page_material_detal .desc").html(data.desc);
                var url= "/material/download?id="+ encodeURI(data.url);
                $("#page_material_detal .content a").attr('href' ,url);
                $(".left-conent-page").hide();
                $("#page_material_detal").show();
            } ,{id:id});
        }
    }

    if(pageData.testpaperList)
    {
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
            element:'#exam_list',
            data: pageData.testpaperList,
            callback:null,
        } );
    }

    if(pageData.articleList)
    {
        updateListTemplate( {
            template:'<li class="box" data-target="{id}"> {title} </li>',
            keys:['id','title'],
            element:'#article_list',
            data: pageData.articleList,
            callback:function () {
                var id = $(this).attr('data-target');
                $.ajax({
                    url : "/article/detail?id="+id,
                    dataType:'json',
                    success:function (response) {
                        console.log(response);
                        $('.left-conent-page').hide();
                        $('#page_article_detail').show();
                        $('#page_article_detail .title').html(response.data.title);
                        $('#page_article_detail .content').html(response.data.body);

                    }
                })
            }
        });
    }
    //清空原始页码内容
    $('#chapter_content').empty();

    showChapterPdf(pageData.currentChapter);

}

//显示pdf
function  showChapterPdf(chapter) {

    if(!chapter.pdfpages )
    {
        chapter.pdfpages = "1";
    }

    var pages    = chapter.pdfpages ;
    var pagesArr = pages.split(',');

    for (var i in pagesArr)
    {
        addPdfPage( pagesArr[i] , 'img' , chapter['root'] );
    }
    return;
}


// 显示当前book的页码 内容
function addPdfPage(pageNum , type , root) {
    _currentBookPage = pageNum;
    $('#chapter_content').empty();
    var pageContent =  document.getElementById('chapter_content')

    if(type== 'img')
    {
        var img   =   document.createElement( 'img' );
        img.src = "/files/book/"+root+"/xytschool_"+pageNum+'.jpg';

        pageContent.appendChild(img);
    }else{
        var orgurl = chapterPdfInfo['pdfurl'];
        PDFJS.workerSrc = '/js/lib/pdf/build/pdf.worker.js';
        var loadingTask = PDFJS.getDocument(orgurl);
        var canvas   =     document.createElement( 'canvas' );
        pageContent.appendChild(canvas);
        loadingTask.promise.then( function(pdf) {
            console.log('PDF loaded');
            var pageNumber = pageNum;
            pdf.getPage(pageNumber).then(function(page) {
                console.log('Page loaded2');
                var scale = 1.3;
                var viewport = page.getViewport(scale);
                // Prepare canvas using PDF page dimensions
                //var canvas = document.getElementById('page-canvas');
                var context = canvas.getContext('2d');
                canvas.height = viewport.height;
                canvas.width = viewport.width;
                // Render PDF page into canvas context
                var renderContext = {
                    canvasContext: context,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);
                renderTask.then(function () {
                    console.log('Page rendered');
                });
            });
        }, function (reason) { console.error(reason); });
    }
}


$(document).ready(function(){

    //窗口大小调整  尺寸调整
    window.onresize = function () {
        var winWidth = $(window).width()
        var winHeight =$(window).height()
        console.log(winWidth);
        $('#main_content').height(winHeight);
        $('.left-conent-page').height(winHeight-50);
    }
    window.onresize();

    var  tree=null;
    //获取树形菜单
    tree = $.fn.zTree.init($("#treeMap"), setting , treeMap[0]);
    // 章节树 显示控制面板
    $('.toppanel-tree').click(function () {
        if($(this).hasClass('toppanel-hide-down'))
        {
            $(this).removeClass('toppanel-hide-down');
            $(this).addClass('toppanel-hide-up');
            $('.tree-warp').css('height','560px');
        }else{
            $(this).removeClass('toppanel-hide-up');
            $(this).addClass('toppanel-hide-down');
            $('.tree-warp').css('height','24px');
        }
    });

    //初始化文章列表内容
    if(articleList){
        updateListTemplate( {
            template:'<li class="box" data-target="{id}"> {title} </li>',
            keys:['id','title'],
            element:'#article_list',
            data: articleList,
            callback:function () {
                    var id = $(this).attr('data-target');
                    // window.location = "http://"+window.location.host+'/index/article-detail?aid='+id;
                    $.ajax({
                        url : "/article/detail?id="+id,
                        dataType:'json',
                        success:function (response) {
                            //console.log(response);
                            $('.left-conent-page').hide();
                            $('#page_article_detail').show();
                            $('#page_article_detail .title').html(response.data.title);
                            $('#page_article_detail .content').html(response.data.body);
                        }
                      })
                }
        });
     }
     // 显示文章内容
     if(articleData)
     {
         $(".left-conent-page").hide();
         $("#page_article_detail").show();
     }

    showChapterPdf(currentChapter);

    $(".page-control .pre-page").click(function () {

        var page =  parseInt(_currentBookPage) - 1;
        console.log(page)
        if (page >= 1)
            addPdfPage(page, 'img', currentChapter.root);
    })

    $(".page-control .next-page").click(function () {
        var page = parseInt(_currentBookPage) +1;
        console.log(page)
        if (page >= 1)
            addPdfPage(page, 'img', currentChapter.root);
    })

    //点击知识点回掉函数
    var pointListClickCallBack = function () {
        var id =  parseInt( $(this).attr('data-target') );
        //console.log(id);
        PointService.getAriticleDetal( function (response) {
            console.log(response);
            var data = response.data;
            var date = new Date( data.createdTime *1000);
            // $("#page_point_detal .date").text(   date.format('yyyy-MM-dd') );
            // $("#page_point_detal .title").text(data.title);
            $("#page_point_detal .desc").html(data.desc);
            //$("#page_point_detal .content").html(data.content);
            var page =$("#page_point_detal").html();
            //页面层-自定义
            layer.open({
                type: 1,
                title: data.title,
                closeBtn: 2,
                area: ['700px', '530px'],
                shadeClose: true,
                skin: 'layui-layer-gw123',
                content: page
            });
        } ,{id:id});
    }
    if(pointList){
        updateListTemplate( {
            template:'<li class="box" data-target="{id}"> {title} </li>',
            keys:['id','title'],
            element:'#point_list',
            data: pointList,
            callback:pointListClickCallBack,
        } );
    }

    //视频内容
    if(videoData.length !=0)
    {
        var data = videoList;
        var date = new Date( data.createTime *1000);
        $("#page_video_detal .date").text(   date.format('yyyy-MM-dd') );
        $("#page_video_detal .title").text(data.title);
        // $("#page_video_detal .desc").html(data.desc);
        var url= "/video/play?url="+ encodeURI(data.url);
        //$("#player").attr('src',url);
        $(".left-conent-page").hide();
        $("#page_video_detal").show();
    }

    //视屏列表
    if(videoList)
    {
        var data = {'chapter': currentChapter };

        var tpl_video_list = ' <li data-target="{id}" data-content="{content}" >\
             <p><img src="/image/video/video1.png"> </p>\
             <b>{title}</b>\
             </li>';
        updateListTemplate( {
            template:tpl_video_list,
            keys:['id','title','desc','content'],
            element:'#viode_list',
            data: videoList,
            callback:function () {
                var id      =  parseInt( $(this).attr('data-target') );
                var content =   $(this).attr('data-content') ;
                var pageContent = '';

                if( typeof content == 'string'&&content.indexOf('http://player.youku.com')===0 )
                {
                    //$('#videoPlayer').attr('src',content);
                    window.open(content);
                    //pageContent =  $('#page_video_detal').html();
                }else {
                    pageContent = '/video/player?id='+id;
                    layer.open({
                        title:'',
                        type: 2,
                        area: ['840px', '640px'],
                        fixed: false, //不固定
                        maxmin: true,
                        content:pageContent
                    });
                }
            },
        } );

        var callback1 = function () {

            // VideoService.getVideoDetal( function (response) {
            //     console.log(response);
            //     var data = response.data;
            //     var date = new Date( data.create_time *1000);
            //
            //     $("#page_video_detal .date").text(   date.format('yyyy-MM-dd') );
            //     $("#page_video_detal .title").text(data.title);
            //     $("#page_video_detal .desc").html(data.desc);
            //     var url= "/video/play?url="+ encodeURI(data.url);
            //     $("#player").attr('src',url);
            //     $(".left-conent-page").hide();
            //     $("#page_video_detal").show();
            // } ,{id:id});
        }

    }

    if(materialList)
    {
        //console.log(materialList)
        var template = '<li class="box row" data-target="{id}">\
            <div class="col-sm-3"><img src="{cover}"></div>\
        <div class="col-sm-9 ">\
        <div class="row"><h5>{title}</h5></div>\
        <div class="row" style="height: 65px"><p>{desc}</p></div>\
        <div class="row">\
        <b>上传时间 <span>{createdTime}</span></b>\
        <a  href="{content}" target="_blank">下载\
        <span class="glyphicon glyphicon-download"></span>\
        </a>\
        </div>\
        </div>\
        </li>';

        updateListTemplate( {
            template:template,
            keys:['id','title','desc','content','createdTime','cover'],
            element:'#material_list',
            data: materialList,
            callback:callback,
        } );

        //获取该节点下面的资料
        var callback = function () {
            var id =  parseInt( $(this).attr('data-target') );
            console.log(id);
            MaterialService.getMaterialDetal( function (response) {
                console.log(response);
                var data = response.data;
                var date = new Date( data.create_time *1000);

                $("#page_material_detal .date").text(   date.format('yyyy-MM-dd') );
                $("#page_material_detal .title").text(data.title);
                $("#page_material_detal .desc").html(data.desc);
                var url= "/material/download?id="+ encodeURI(data.url);
                $("#page_material_detal .content a").attr('href' ,url);
                $(".left-conent-page").hide();
                $("#page_material_detal").show();
            } ,{id:id});
        }
    }

    if(testpaperList)
    {
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
            element:'#exam_list',
            data: testpaperList,
            callback:null,
        } );
    }
    //关注课程
    $('#join_course').click(function () {
        ChapterService.joinCourse(function (response) {
            console.log(response);
        },{ id : rootChapter});
    });

    //功能导航栏点击响应事件
    $(".page-nav li").click(function()
    {
        var  target = $(this).attr('data-target');
        $('.left-conent-page').hide();
        $("#"+target).show();
    });

    //点击获取试卷列表
    $("[data-target= page_exam_list]").click(function () {
        console.log('page_exam_list');
        $(".left-conent-page").hide();
        $("#page_exam_list").show();
       /*
       *  ExamService.getExamList(function (response) {
        console.log(response);
        var callback = function () {
        var id =  parseInt( $(this).attr('data-target') );
        console.log(id);
        PointService.getAriticleDetal( function (response) {
        console.log(response);

        $(".left-conent-page").hide();
        $("#page_point_detal").show();
        } ,{id:id});
        }

        var  tpl_exam_list ='<li >\
        <div class="li-image"><img src="/image/exam/exam_1.png"></div>\
        <div class="li-content">\
        <a href="exam/mexam-detal?id={id}" target="_blank">\
        <div class="list-title">{title}\
        <span class="badge">新</span> </div>\
        </a>\
        <p class="list-desc"> {intro} </p>\
        </div>\
        <div style="clear: both"></div>\
        </li>';

        updateListTemplate( {
        template: tpl_exam_list ,
        keys:['id','title','intro'],
        element:'#exam_list',
        data: response.data.examList,
        callback:null,
        } );

        },{});
       * */
    });// end  $("#page_exam_list").click(

    //点击获取文章列表
    $("[data-target= page_point_list_]").click(function () {
        var data = {'chapter': currentChapter };
        $(".left-conent-page").hide();
        $("#page_point_list").show();

    });// end $("[data-target= page_point_list]").click())}

    $("[data-target= page_video_list]").click(function () {
        $(".left-conent-page").hide();
        $("#page_video_list").show();
        /*
         VideoService.getVideoList(function (response) {
         //console.log(response);
         var callback = function () {
         var id =  parseInt( $(this).attr('data-target') );
         console.log(id);
         VideoService.getVideoDetal( function (response) {
         console.log(response);
         var data = response.data;
         var date = new Date( data.create_time *1000);

         $("#page_video_detal .date").text(   date.format('yyyy-MM-dd') );
         $("#page_video_detal .title").text(data.title);
         $("#page_video_detal .desc").html(data.desc);
         var url= "/video/play?url="+ encodeURI(data.url);
         $("#player").attr('src',url);
         $(".left-conent-page").hide();
         $("#page_video_detal").show();
         } ,{id:id});
         }
         var tpl_video_list = ' <li  data-target="{id}">\
         <p><img src="/image/video/video1.png"> </p>\
         <b>{title}</b>\
         </li>';
         updateListTemplate( {
         template:tpl_video_list,
         keys:['id','title','desc'],
         element:'#viode_list',
         data: response.data,
         callback:callback,
         } );

         } ,data );

        * */
    });// end $("[data-target= page_video_list]").click())}

    $("[data-target= page_material_list]").click(function () {
        $(".left-conent-page").hide();
        $("#page_material_list").show();
       /* var data = {'chapter': currentChapter };
        //获取该节点下面的资料
        MaterialService.getMaterialList(function (response) {
        //console.log(response);
        var callback = function () {
        var id =  parseInt( $(this).attr('data-target') );
        console.log(id);
        MaterialService.getMaterialDetal( function (response) {
        console.log(response);
        var data = response.data;
        var date = new Date( data.create_time *1000);

        $("#page_material_detal .date").text(   date.format('yyyy-MM-dd') );
        $("#page_material_detal .title").text(data.title);
        $("#page_material_detal .desc").html(data.desc);
        var url= "/material/download?id="+ encodeURI(data.url);
        $("#page_material_detal .content a").attr('href' ,url);
        $(".left-conent-page").hide();
        $("#page_material_detal").show();
        } ,{id:id});
        }

        updateListTemplate( {
        template:'<li class="box" data-target="{id}">' +
        '<span class="glyphicon glyphicon-file"></span> ' +
        '{title}  ' +
        '<b>下载量 <span>100</span></b>' +
        '<b>上传时间 <span>2016-10-2</span></b>' +
        '</li>',
        keys:['id','title'],
        element:'#material_list',
        data: response.data,
        callback:callback,
        } );
        } ,data );*/

    });// end $("[data-target= page_material_list]").click())}

    $("[data-target= page_common_list]").click(function () {

    });// end $("[data-target= page_common_list]").click())}


    /******************** 讨论区  **********************/
    var ue = UE.getEditor('post_editor',{
        toolbars: [
            [  'undo', 'redo', 'bold']
        ],
        serverUrl:'/uploader/ue',
        autoHeightEnabled:false
    })

    //最大消息id
    var maxMsgId = 0;
    function  appendToPostList(data) {
        if( maxMsgId< data.id ) maxMsgId =data.id;
        var  tpl = '<li class="box" data-target="{0}"> {1} </li>';
        var s=tpl.format(data.id ,data.content);
        //console.log(s);
        $(s).insertBefore( $('#post_list').children().first() );
    }
    function  refresh() {
        PostService.getPostList(function (response) {
            var list = response.data;

            for( var i in list)
            {
                appendToPostList(list[i]);
            }
        },{ 'chapter' : currentChapter.id ,'maxMsgId':maxMsgId });
    }
    //refresh();
    //刷新
    $('#btn_send_refresh').click(function () {
        refresh();
    });
    //发帖子
    $('#btn_send_post').click(function () {
        var post= ue.getContent();
        var lastId = 0;
        var data = {'chapter': currentTreeNode.parents ,'content':post ,'lastId':lastId };
        PostService.createPost(function (respose) {
            console.log(respose);
            if(maxMsgId<respose.data.id) maxMsgId =respose.data.id;
            //var  post = {content:post , id:respose.data.id};
            var  tpl = '<li class="box" data-target="{0}"> {1} </li>';
            var s=tpl.format(respose.data.id ,post);
            $(s).insertBefore( $('#post_list').children().first() );
        },data);
    });

    //添加滑动
   // new addScroll('post_list_wrap','post_list','scrollDiv');

});// end ready








