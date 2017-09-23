
$(document).ready(function(){

    //获取笔记列表 大侠 列表 --- 右2
    var daxiaTemplate = ' <li>\
        <div class="pic"><img src="/images/tip_1.jpg" ><span><a href="{id}" target="_blank"></a></span></div>\
        <div class="rinfo"><a href="/index/article-detail?id={id}" target="_blank" >{title}</a><p><span class="fl">讲师：<a href="{id}" target="_blank">{user}</a></span></p></div>\
        </li>';
    //排行列表
    var hotListTemplate = '<li class="line">\
        <span class="redbg">{index}</span>\
        <div class="rinfo1">\
        <a href="/index/article-detail?id={id}" target="_blank" title="{title}" style="display:block; overflow:hidden; height:22px; line-height:22px;">{title}</a>\
        </div>\
        </li>';
    //最新文章
    var lastListTemplate= '<li><a href="" target="_blank"><i class="tcolor">原创 | </i></a><a href="/index/article-detail?id={id}" title="" ><span>{title}</span></a></li>';
    //获取笔记列表 左 一
    var template_main_left_item = ' <li>\
        <div class="pic"><a href="" target="_blank">\
        <img src="{cover}"></a>\
        <p><a href="#" target="_blank">{categoryName}</a></p></div>\
        <div class="rinfo">\
        <a href="/index/article-detail?id={id}" target="_blank">{title}</a><i class="date">{date}</i>\
        <p>{desc}</p>\
        <div class="time"><span>\
        {chapterNameTags}\
        </span>\
        </div>\
        </div>\
        </li>';

    //文章导航列表=
    var templateNav = '<a href="javascript:;" id="tag_{id}" class="">{name}</a>';
    //点击获取分类下的文章
    function  articleCategoyClick() {
        var id = $(this).attr('id');
        //console.log(id);
        var articles=null;
        if(id==0)
        {
            articles = recommendArticles;
        }else{
            var list = articleCategorys[id];
            //console.log(articleCategorys);
            articles = list['articles'];
        }
        var config = {
            template:template_main_left_item,
            keys:['id','title' ,'date','desc','category','username' , 'categoryName','chapterNameTags','cover'],
            element:'.main-article-list ul:first',
            data: articles,
        };
        updateListTemplate( config );
    }

    $('.article-category').click(articleCategoyClick);
   // $('.article-category').first().trigger('click');

    function  initList() {
      var  config1 = {
          template:lastListTemplate,
          keys:['id','title'],
          element:'.article-last ul:first',
          data: lastArticle,
      };
      updateListTemplate( config1 );

      config = {
          template:hotListTemplate,
          keys:['id','title'],
          element:'.article-hot ul:first',
          data: hotArticle,
      };
      updateListTemplate( config );

      var config = {
          template:template_main_left_item,
          keys:['id','title' ,'date','desc','category','username' ,'categoryName','chapterNameTags' ,'cover'],
          element:'.middle-left-list ul:first',
          data: recommendArticles,
          callback:function () {},
      };
      updateListTemplate( config );
  }

  initList();

    onResponse = function (response)
    {
        //console.log(reponse)
        if(response.status==1)
        {
            var config = {
                template:templateNav,
                keys:['id','name'],
                element:'.middle-left-nav',
                data: response.data.nav,
                callback:onResponseCallBcak_2,
            };
           // console.log(config);
            updateListTemplate( config );

            //点击文章列表触发事件 编辑文章
             config = {
                template:tuijianTemplate,
                keys:['id','title'],
                element:'.zd-list ul:first',
                data: response.data.lastArticle,
                callback:function () {},
            };
            //console.log(config);
            updateListTemplate( config );

            var  config1 = {
                template:daxiaTemplate,
                keys:['id','title'],
                element:'.jp-list ul:first',
                data: response.data.hotUser,
                callback:function () {},
            };
            updateListTemplate( config1 );

             config = {
                template:paihangTemplate2,
                keys:['id','title'],
                element:'.ph-list ul:first',
                data: response.data.hotArticle,
                callback:function () {},
            };
            updateListTemplate( config );


        }else{
            $.waring('获取数据异常');
        }
    }
    //填充主文章列表内容
    onResponseCallBcak_1 = function (response)
    {
        if(response.status==1)
        {
            var  data = response.data;
            var  param = response.param;
            var config = {
                template:template_main_left_item,
                keys:['id','title'],
                element:'.middle-left-list ul:first',
                data: data,
                callback:function () {},
            };
            updateListTemplate( config );
        }else{
            $.waring('获取数据异常');
        }
    }
    //点击导航列表触发事件
    onResponseCallBcak_2 = function () {
        console.log("onResposeCallBack2")
        var idstr = $(this).attr('id');
        var  id = idstr.split("_")[1];
        PointService.getArticleListByTag( onResponseCallBcak_1 ,{tag:id});
    }

    //IndexService.getData( onResponse ,{});
    //PointService.getArticleListByTag( onResponseCallBcak_1);
    //TagService.getLvlOne( onResponse ,{});

});

/*************************** 上传代码 ************************/

