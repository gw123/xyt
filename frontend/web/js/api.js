
/*****
 *  从服务器获取数据
 * @param url        请求网址
 * @param callback   回掉函数
 * @param data       请求参数 json格式
 */
function  getServer( url,callback , data ,hideLoading )
{
    if(!hideLoading)
    var loading = $.loading();
    typeof (data) == 'undefined' ? data={} : '';
    if( typeof  callback !="function" )
    {   callback = function () {  alert('success');}; }
    var request = {};
    if(!_csrf_token) console.log('Set token !!!!');
    request['_csrf-frontend'] = _csrf_token;
    request.data = data;

    $.ajax({
        url:url,
        data:request,
        dataType:'json',
        type:'post',
        success:function(response){  callback(response);  $.closeLoading(loading);  },
        error:function () {
            $.closeLoading(loading);
            alert(url+"  not found !!");
        }
    });
}

function errorTip(msg) {
    msg?'':msg='';
    $.waring('执行失败'+msg);
}
function succesTip(msg) {
    $.alert('success'+msg);
}
function makeParseResultFun(msg, errormsg) {

    if(msg==undefined) msg='成功';
    if(errormsg==undefined) errormsg='执行失败';
    return function(response) {
        console.log(response)
        if(response.status=='1')
        {
            $.alert(msg);
        }else
        {
            $.waring(errormsg);
        }
    }

}

function GetQueryString(name)
{
    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if(r!=null)return  unescape(r[2]); return null;
}

UserService ={
    login : function (username,password ,remeberMe ,callback) {
        var url =  '/site/login';
        if(! /[\w_@]{3,20}/.test(username) )
        {
            callback( { msg:'用户名不合法'} );
            return
        }
        if(!/[\w_@]{5,20}/.test(password))
        {
            callback({ msg:'密码不合法'});
            return;
        }
        remeberMe = remeberMe? true : false;
        var data = {
            username : username,
            password : password,
            remoberMe:remeberMe
        }
        getServer(url ,callback , data);
    },
    signup : function (email,username,password  ,callback) {
        var url =  '/site/signup';
        if(! /[\w_@]{3,20}/.test(username) )
        {
            callback( { msg:'用户名不合法'} );  return
        }
        if(!/[\w_@]{5,20}/.test(password))
        {
            callback({ msg:'密码不合法'}); return;
        }
        if(!/[\w_]{5,40}@\w{1,10}\.\w{1,10}/.test(email))
        {
            callback({ msg:'邮箱格式有问题'}); return;
        }


        var data = {
            email :  email,
            nickname : username,
            password : password,
        }
        console.log(data)
        getServer(url ,callback , data);
    },
    logout: function () {
        callback = function (response) {
            if(response.status==1)
            {
                window.location.href = '/';
            }
        }
        getServer("/site/logout" ,callback );
    },
    updateSetting: function (data , callback) {
        var url =  '/user/setting';
        getServer(url ,callback , data);
    }
}

IndexService = {
    getData: function (callback , data) {
        var url =  '/index/get-index';
        getServer(url ,callback , data);
    },
    getIndex: function () {
        /*加载数据*/
        $.ajax({
            type:'GET',
            url:'/index/get-lesson-desc',
            dataType:"json",
            success:function (response) {
                //console.log(response.data);
                var data = response.data;

                var t1 = '<div alt="高数" class="slide_page">\
                                    <img src="images/page_1.png">\
                                   <div class="course_desc">\
                                   </div> </div>';

                var t2_start = '<ul> ';
                var t2_end = '</ul> <div class="clear"></div>';
                //console.log(data);
                for (var j in data)
                {   //遍历分类 一页
                    var lessons = data[j]['lessons'];
                    var type    = data[j]['type'];
                    var page = $(t1);
                    //
                    for (var lvl2 in lessons)
                    { ////该分类下的课程
                        var course_desc = page.find(".course_desc");
                        var lesson = lessons[lvl2];
                        //console.log(lesson);
                        {
                            var courses_str=t2_start;
                            var chapters =lessons[lvl2].chapters;
                            for(var i in  chapters )
                            {
                                courses_str+='<li>'+chapters[i]+'</li>';
                            }
                            courses_str+=t2_end;
                            //console.log(courses_str);
                            course_desc.append(courses_str);
                        }
                    }

                    page.attr("alt",type);
                    $("#kit-slideshow").append(page);
                }

            },
            erros:function () {
                alter('error');
            }
        });
    }
}

DetalService ={
    getData: function (callback , data) {
        var url =  '/detal/get-detal';
        getServer(url ,callback , data);
    },
}

ChapterService = {
    importChapter: function (callback , data) {
        var url =  '/chapter/import-chapter';
        getServer(url ,callback , data);
    }
    ,
    getChapter: function (callback , data) {
        var url =  '/chapter/get-chapter';
        getServer(url ,callback , data);
    }
    ,
    getRootChapterByTag: function (callback , data) {
        var url =  '/chapter/get-root-chapter-by-tag';
        getServer(url ,callback , data);
    }
    ,
    createChapterNode: function (callback ,data) {
        var url = '/chapter/create-chapter-node';
        getServer(url ,callback , data);
    }
    ,
    moveNode: function (callback ,data) {
        var url = '/chapter/move-node';
        getServer(url ,callback , data);
    }
    ,
    updateNode :function (callback ,data) {
        var url = '/chapter/update-chapter-node';
        getServer(url ,callback , data);
    }
    ,
    deleteChapterNode: function(callback ,data){
        var url = '/chapter/del-chapter-node';
        getServer(url ,callback , data);
    },
    getTagTree:function (callback ,data) {
        var url = '/chapter/get-tag-tree';
        getServer(url ,callback , data);
    }
    ,
    joinCourse: function ( callback , data ) {
        var url = '/chapter/join-course';
        getServer(url ,callback , data);
    }
}

CategoryService = {
    getNode: function (callback , data) {
        var url =  '/category/get-node';
        getServer(url ,callback , data);
    },
    createNode: function (callback ,data ) {
        var url = '/category/create-node';
        getServer(url ,callback , data);
    },
    updateNode :function (callback ,data) {
        var url = '/category/update-node';
        getServer(url ,callback , data);
    },
    deleteNode: function(callback ,data){
        var url = '/category/del-node';
        getServer(url ,callback , data);
    },
    moveNode : function (callback,data) {
        var url = '/category/move-node';
        getServer(url ,callback , data);
    }
}

PointService = {
    getPointListByChapter:function (callback,data) {
        var url = '/point/get-point-by-chapter';
        getServer(url ,callback , data);
    },
    createArticle: function (callback ,data) {
        var url = '/point/create-ajax';
        getServer(url ,callback , data);
    },
    getArticleList:function (callback,data) {
        var url = '/point/get-article-list';
        getServer(url ,callback , data);
    },
    getArticleListByTag:function (callback,data) {
        var url = '/point/get-article-by-tag';
        getServer(url ,callback , data);
    },
    getArticleListByHot:function (callback,data) {
        var url = '/point/get-article-by-hot';
        getServer(url ,callback , data);
    },
    getArticleListByUser:function (callback,data) {
        var url = '/point/get-article-by-tag';
        getServer(url ,callback , data);
    },
    getRecomendArticle:function (callback,data) {
        var url = '/point/get-article-by-recommend';
        getServer(url ,callback , data);
    },
    getArticleListByKeyWord:function (callback,data) {
        var url = '/point/get-article-by-keyword';
        getServer(url ,callback , data);
    },
    getAriticleDetal:function (callback,data) {
        var  url ="/point/get-article-detal";
        getServer(url,callback,data);
    }
}

ArticleService = {
    createArticle: function (callback ,data) {
        var url = '/article/create-ajax';
        getServer(url ,callback , data);
    },
    getArticleList:function (callback,data) {
        var url = '/article/get-article-list';
        getServer(url ,callback , data);
    },
    getArticleListByChapter:function (callback,data) {
        var url = '/article/get-article-by-chapter';
        getServer(url ,callback , data);
    },
    getArticleListByHot:function (callback,data) {
        var url = '/article/get-article-by-hot';
        getServer(url ,callback , data);
    },
    getArticleListByUser:function (callback,data) {
        var url = '/article/get-article-by-tag';
        getServer(url ,callback , data);
    },
    getRecomendArticle:function (callback,data) {
        var url = '/article/get-article-by-recommend';
        getServer(url ,callback , data);
    },
    getArticleListByKeyWord:function (callback,data) {
        var url = '/article/get-article-by-keyword';
        getServer(url ,callback , data);
    },
    getAriticleDetal:function (callback,data) {
        var  url ="/article/get-article-detal";
        getServer(url,callback,data);
    }
}

/**
 *   评论
 * */
CommentService = {
    createComment: function (callback ,data) {
        var url = '/comment/create-ajax';
        getServer(url ,callback , data);
    },
    getCommentList:function (callback,data) {
        var url = '/comment/get-comment-list';
        getServer(url ,callback , data);
    },
    getCommentListByTag:function (callback,data) {
        var url = '/comment/get-comment-by-tag';
        getServer(url ,callback , data);
    },
    getCommentListByHot:function (callback,data) {
        var url = '/comment/get-comment-by-tag';
        getServer(url ,callback , data);
    },
    getCommentListByUser:function (callback,data) {
        var url = '/comment/get-comment-by-tag';
        getServer(url ,callback , data);
    },
    getRecomendComment:function (callback,data) {
        var url = '/comment/get-comment-by-tag';
        getServer(url ,callback , data);
    },
    getCommentListByKeyWord:function (callback,data) {
        var url = '/comment/get-comment-by-tag';
        getServer(url ,callback , data);
    },
    getCommentDetal:function (callback,data) {
        var  url ="/comment/get-comment-detal";
        getServer(url,callback,data);
    }
}

/**
 * 帖子接口·
 * */
PostService = {
    createPost: function (callback ,data) {
        var url = '/post/create-ajax';
        getServer(url ,callback , data);
    },
    getPostList:function (callback,data) {
        var url = '/post/get-post-list';
        getServer(url ,callback , data);
    },
    getPostListByTag:function (callback,data) {
        var url = '/post/get-post-by-tag';
        getServer(url ,callback , data);
    },
    getPostListByHot:function (callback,data) {
        var url = '/post/get-post-by-tag';
        getServer(url ,callback , data);
    },
    getPostListByUser:function (callback,data) {
        var url = '/post/get-post-by-tag';
        getServer(url ,callback , data);
    },
    getRecomendPost:function (callback,data) {
        var url = '/post/get-post-by-tag';
        getServer(url ,callback , data);
    },
    getPostListByKeyWord:function (callback,data) {
        var url = '/post/get-post-by-tag';
        getServer(url ,callback , data);
    },
    getPostDetal:function (callback,data) {
        var  url ="/post/get-post-detal";
        getServer(url,callback,data);
    }
}

/**
 * 试卷接口·
 * */
PaperService = {
    getPaperListByChapter:function (callback,data) {
        var url = '/paper/get-paper-by-chapter';
        getServer(url ,callback , data);
    },
    createExam: function (callback ,data) {
        var url = '/exam/create-ajax';
        getServer(url ,callback , data);
    },
    getExamList:function (callback,data) {
        var url = '/exam/get-exam-list';
        getServer(url ,callback , data);
    },

    getExamListByUser:function (callback,data) {
        var url = '/exam/get-exam-by-tag';
        getServer(url ,callback , data);
    },
    getRecomendExam:function (callback,data) {
        var url = '/exam/get-exam-by-tag';
        getServer(url ,callback , data);
    },
}

/**
 * 资料
 * */
MaterialService = {
    getMateriaListByChapter:function (callback,data) {
        var url = '/material/get-material-by-chapter';
        getServer(url ,callback , data);
    },
    createMaterial :function (callback ,data) {
        var url = '/material/create-ajax';
        getServer(url ,callback , data);
    },
    deleteMaterial :function (callback ,data) {
        var url = '/material/delete-material';
        getServer(url ,callback , data);
    },
}

VideoService = {
    getVideoListByChapter:function (callback,data) {
        var url = '/video/get-video-by-chapter';
        getServer(url ,callback , data);
    },
    createVideo :function (callback ,data) {
        var url = '/video/create-ajax';
        getServer(url ,callback , data);
    },
    getVideoDetal:function (callback ,data) {
        var url = '/video/get-video-detal';
        getServer(url ,callback , data);
    },
    updateVideo :function (callback ,data) {
        var url = '/video/update-Video';
        getServer(url ,callback , data);
    },
    getVideoList :function (callback ,data) {
        var url = '/video/get-video-list';
        getServer(url ,callback , data);
    },
    deleteVideo :function (callback ,data) {
        var url = '/video/delete-video';
        getServer(url ,callback , data);
    },
    getRecommentVideoList :function (callback ,data) {
        var url = '/video/get-video-list';
        getServer(url ,callback , data);
    },

}

UploaderServer = function (param) {
    var  server ={
        uploaderId:'',
        //上传回掉方法
        onProgress : function (evt) {
            var loaded = evt.loaded;     //已经上传大小情况
            var tot    = evt.total;      //附件总大小
            var per    = Math.floor(100*loaded/tot);  //已经上传的百分比
            // console.log(per);
            $(".progress-bar").css("width" , per +"%");
        },
        //服务器返回的数据
        severReturn : {},
        uploader : function (callback ,serverUrl ) {
            var _this = this;
            if(!serverUrl) { $.waring('请配置上传地址'); return; }

            var uploader = $('#'+_this.uploaderId);
            uploader.find('.upfile_progress').show();
            var file =  uploader.find('.upload_file_input')[0].files[0];
            //console.log(file);
            var localUrl= window.URL.createObjectURL(file)
            //显示
            uploader.find('.upload_dispaly').prop('src',localUrl)
            var formData  = new FormData();
            formData.append('file',file)
            console.log('begin ajax');
            console.log(serverUrl)
            $.ajax({
                type: "POST",
                url: serverUrl ,//"/uploader/upload-video",
                data: formData ,　　//这里上传的数据使用了formData 对象
                processData : false,
                contentType : false ,  //必须false才会自动加上正确的Content-Type
                //这里我们先拿到jQuery产生的 XMLHttpRequest对象，为其增加 progress 事件绑定，然后再返回交给ajax使用
                xhr: function(){
                    var xhr = $.ajaxSettings.xhr();
                    if( _this.onProgress && xhr.upload) {
                        xhr.upload.addEventListener("progress" , _this.onProgress , false);
                        return xhr;
                    }
                },
                dataType:'json',
                success:callback,
                error:function () {errorTip('网络出错!');}
            });
        },
        onsuccess : function () {
            var _this = this;
            return  function (response) {
                if(response.state=='SUCCESS')
                {
                    //console.log(response)
                    _this.severReturn = response;
                    succesTip('上传成功');
                }else{
                    _this.severReturn = {};
                    errorTip(response.msg);
                }

            };
        },
        template:function (btn_show,input_save_url ,serverUrl) {

            var _this= this;
            if(_this._isInit) return;
            // console.log(btn_show)
            $.get('/js/template/upload-video.html',function (response) {
                var  uploader = $(response);
                _this.uploaderId = "uploader-"+Date.now();
                uploader.attr('id',_this.uploaderId);
                $('body').append(uploader);
                console.log($(btn_show))

                $(btn_show).click(function () { uploader.modal('show'); });

                uploader.find('.btn-on-upload').click(function () {
                    console.log('btn-on-upload');
                    _this.uploader(_this.onsuccess() ,serverUrl);
                });

                uploader.find('.btn-on-save').click(function () {
                    //console.log(_this.severReturn)
                    if(_this.severReturn.url == undefined)
                    { errorTip('请上传文件'); return; }
                    $(input_save_url).val(_this.severReturn.id);
                    _this.severReturn = {};
                     //$('#up_video_model .upload_file_input').val();
                     uploader.find('.upfile_progress').hide();
                     uploader.modal('hide');
                     $('.modal-backdrop').hide();
                 })
                $('.modal-backdrop').click(function () {
                    //console.log('lll')
                    uploader.modal('hide'); $('.modal-backdrop').hide();
                })
                uploader.find('.btn-close').click(function () {
                    uploader.modal('hide'); $('.modal-backdrop').hide();
                })


            });
        },
        _isInit  :false,
        init:function (param) {
            var btn_show = param.btn_show;
            var input_save_url = param.input_save_url;
            var serverUrl = param.serverUrl;
            //console.log(param)
            // var success_callback = param.success_callback;
            if(!this._isInit)
            {
                this.template(btn_show , input_save_url ,serverUrl );
            }
            this._isInit=true;
        }
    }
    server.init(param);
    return server;
}
