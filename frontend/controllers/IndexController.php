<?php

namespace frontend\controllers;

use common\models\Article;
use common\models\ArticleSearch;
use common\models\BookSearch;
use common\models\ChapterSearch;
use common\models\CourseLessonSearch;
use common\models\CourseSearch;
use common\models\Material;
use common\models\MaterialSearch;
use common\models\PointSearch;
use common\models\UserSearch;
use common\models\Video;
use common\models\VideoSearch;
use common\models\NotificationSearch;
use common\utils\TreeUtils;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

use common\models\CategorySearch;
use common\models\Point;
use common\models\PointQuery;
use common\models\User;
use common\utils\Log;

/**
 * AlbumController implements the CRUD actions for Album model.
 */
class  IndexController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /***
     * 首页内容
     */
    public function actionIndex()
    {
        $this->layout= false;
        $categoryGroup = Yii::$app->request->get('ctype',10);

        $lastNotification  = NotificationSearch::getLast();
        //就是默认的分类
        $lastArticles = ArticleSearch::getLast(5);
        $lastBooks    = BookSearch::getLast('5');

        $lastVideos   = VideoSearch::getLast(5);
        $lastMaterials = MaterialSearch::getLast(5);

        $recommendArticle = ArticleSearch::getRecommend();
        $articleCategorysAndData = ArticleSearch::getArticlesByCategory();
        $hostArticle = ArticleSearch::getHot();
        $lastArticle = ArticleSearch::getLast();

        //$lvl2CategoryAndBooks  = CategorySearch::getLvl2CategoryAndBooks();
        $categoryTree = CategorySearch::getCategoryTreeByGourp($categoryGroup);

        $data= [
            'categoryTree'=>$categoryTree,
           // 'lvl2CategoryAndBooks'=>$lvl2CategoryAndBooks,
            'notifications'=>$lastNotification,

            'lastArticles'=>$lastArticles,
            'lastBooks'=>$lastBooks,
            'lastVideos'=>$lastVideos,
            'lastMaterials'=>$lastMaterials,
            'hotArticle'=>$hostArticle,
            'lastArticle'=>$lastArticle,
            'articleCategorys'=>$articleCategorysAndData,
            'recommendArticles'=>$recommendArticle ,

        ];
        return $this->render('index',$data);
    }

    /***
     * 首页文章内容
     */
    public function actionArticle()
    {
        $this->layout= "index";
        $hostArticle = ArticleSearch::getHot();
        $lastArticle = ArticleSearch::getLast();
        //就是默认的分类
        $recommendArticle = ArticleSearch::getRecommend();
        $articleCategorysAndData = ArticleSearch::getArticlesByCategory();

        $data= [
                'hotArticle'=>$hostArticle,
                'lastArticle'=>$lastArticle,
                'articleCategorys'=>$articleCategorysAndData,
                'recommendArticles'=>$recommendArticle ,
               // 'hotUser'=>$hosUser ,
               // 'carousel'=>$carousel
               ];
        return $this->render('articleIndex',$data);
    }

    /***
     * 书籍列表
     * @return string
     */
    public function actionArticleList()
    {
        $this->layout="index";
        $category = Yii::$app->request->get('category');
        $page     = Yii::$app->request->get('page' , 1);
        $pagesize = Yii::$app->request->get('pagesize',12);
        $keyword  = Yii::$app->request->get('keyword','');
        $keyword = substr($keyword,0,30);

        if(strrpos($category ,','))
            $category = substr($category , strrpos($category ,',')+1);

        $category = intval($category);
        $result = ArticleSearch::getPageByCategory($category ,$page ,$pagesize ,$keyword);
        $articles = $result['data'];
        $total  = $result['total'];
        $totalPage = intval( ($total-1)/$pagesize+1 );

        $categoryArray = [];
        $currentCategory =CategorySearch::find()->where(['id'=>$category])->asArray()->one();
        if($currentCategory['parentId'])
        {
            $parentCategory =CategorySearch::find()->where(['id'=>$currentCategory['parentId'] ])->asArray()->one();
            $categoryArray[] = $parentCategory;
        }
        $categoryArray[] = $currentCategory;
        $bookCategoryTree =  CategorySearch::getBookCategoryTree();
        $bookLvl1Category =  CategorySearch::getBooklvl1Category();
        //var_dump($bookCategoryTree); exit();

        $data= [
            'categoryTree'=>$bookCategoryTree,
            'bookLvl1Category'=>$bookLvl1Category,
            'totalPage'=>$totalPage ,
            'lists'=>$articles,
            'currentCategorys'=>$categoryArray
        ];
        // var_dump($data); exit();
        return $this->render('article_list',$data);
    }

    /***
     * 文章详情
     * @return string
     */
    public  function actionArticleDetail()
    {
        $id = Yii::$app->request->get('id');
        $article =  Article::findOne(['id'=>$id]);
        if(empty($article))
            return $this->renderPartial('/site/error',['name'=>'资源问题','message'=>'查找的文章不存在或者没有开放']);

        $article =$article->getAttributes();
        $other =  ArticleSearch::getLike($id);
        $isCollect = false;
        if( ! Yii::$app->user->isGuest)
        {
            $uid =Yii::$app->user->id;
            if( User::isCollect($uid ,'article' ,$id))
                $isCollect = true;
        }
        $user = User::findOne(['id'=>$article['userId']]);
        $article['nickname'] = $user['nickname'];
        $article['category'] =  CategorySearch::getTitlesByIdstr($article['category']);

        $comments =  UserSearch::getComments('article' ,$id );
        $comments = TreeUtils::list2tree($comments,'parentId');
        //var_dump($comments); exit();
        $data  = [ 'article'=>$article ,'other'=> $other ,'isCollect'=>$isCollect ,'comments'=>$comments ];
        $this->layout = 'index';
        return $this->render( 'articleDetail' ,$data );
    }

    /***
     * 书籍列表
     * @return string
     */
    public function actionBook()
    {
        $this->layout="index";
        $category = Yii::$app->request->get('category');
        $page     = Yii::$app->request->get('page' , 1);
        $pagesize = Yii::$app->request->get('pagesize',12);
        $keyword  = Yii::$app->request->get('keyword','');
        $keyword = substr($keyword,0,30);

        if(strrpos($category ,','))
        $category = substr($category , strrpos($category ,',')+1);

        $category = intval($category);
        $result = BookSearch::getPageByCategory($category ,$page ,$pagesize ,$keyword);
        $books  = $result['data'];
        $total  = $result['total'];
        $totalPage = intval( ($total-1)/$pagesize+1 );

        $categoryArray = [];
        $currentCategory =CategorySearch::find()->where(['id'=>$category])->asArray()->one();
        if($currentCategory['parentId'])
        {
            $parentCategory =CategorySearch::find()->where(['id'=>$currentCategory['parentId'] ])->asArray()->one();
            $categoryArray[] = $parentCategory;
        }
        $categoryArray[] = $currentCategory;

        $bookCategoryTree =  CategorySearch::getBookCategoryTree();
        $bookLvl1Category =  CategorySearch::getBooklvl1Category();
        $data= [
            'categoryTree'=>$bookCategoryTree,
            'bookLvl1Category'=>$bookLvl1Category,
            'totalPage'=>$totalPage ,
            'lists'=>$books,
            'currentCategorys'=>$categoryArray
        ];
       // var_dump($data); exit();
        return $this->render('book_list',$data);
    }

    /***
     *
     */
    public  function actionBookDetail()
    {
        $chapterId = Yii::$app->request->get('id');
        if( empty($chapterId) )
        {
            $bookId = Yii::$app->request->get('bookId');
            $currentChapter = ChapterSearch::findOne( [ 'bookId'=>$bookId ,'lvl'=>1 ] );
        }else{
            $currentChapter = ChapterSearch::findOne( [ 'id'=>$chapterId  ] );
        }

        if(!$currentChapter)
        {
            return $this->renderPartial('/site/error',['name'=>'资源问题','message'=>'书籍暂时无内容']);
        }
        $chapterId = $currentChapter['id'];

        $currentChapter = $currentChapter->getAttributes();
        $chapterParents = ChapterSearch::getParents($chapterId);
        $currentChapter['parents'] = $chapterParents;

        if( empty($currentChapter['cover']) )
            $currentChapter['cover'] = '/images/default.jpg';

        //$pointList     =   PointSearch::getListByChapterId($chapterId);
        //$testPaperList =   CourseLessonSearch::getTestPaperListByChapter($chapterId);
        $videoList     =   VideoSearch::getListByChapterId($chapterId);
        $materialList  =   MaterialSearch::getListByChapterId($chapterId);
        $articleList   =   ArticleSearch::getArticleListByChapterId($chapterId);
        $articleData   =   ArticleSearch::find()->where(['id'=>Yii::$app->request->get('aid')])->createCommand()->queryOne();
        $data = [
            'currentChapter'=>$currentChapter,
            'rootChapter'=>0,
            'videoList'=>$videoList,
            //'pointList'=>$pointList,
            'materialList'=>$materialList,
            //'testpaperList'=>$testPaperList,
            'articleList'=>$articleList,
            'articleData'=>$articleData,
            'join'=>false,
        ];

        //Ajax异步请求返回
        if(Yii::$app->request->isAjax)
        {
            Yii::$app->response->format =  Response::FORMAT_JSON;
            return [ 'status'=>1 , 'data'=>$data ];

        }else{
            if( Yii::$app->user->isGuest )
                $user =['nickname'=>'未登录', 'id'=>0,'auth_key'=>''] ;
            else
                $user = User::findOne(['id'=> Yii::$app->user->getId()])->getAttributes();

            $data['user'] = ['nickname'=>$user['nickname'] , 'uid'=>$user['id'] ,'auth_key'=>$user['auth_key']];

            $treeMap = ChapterSearch::getTreeMap($currentChapter['root']);
            $data['chapterTree'] = $treeMap;

            //var_dump($data); exit();
            $this->layout = false;
            return $this->render('detal' , $data);
        }

    }

    /***
     * 书籍中章节的内容
     */
    public function actionGetChapterDetail()
    {
        if(!Yii::$app->request->isAjax)
            return $this->asJson( [ 'status'=>0 , 'msg'=>'访问失败' ]);

        $chapterId = Yii::$app->request->post('id' , 0);
        $currentChapter = ChapterSearch::findOne( [ 'id'=>$chapterId ] );

        if(!$currentChapter)
        {
            return $this->asJson( [ 'status'=>0 , 'msg'=>'访问资源不存在' ]);
        }

        $currentChapter = $currentChapter->getAttributes();
        $chapterParents = ChapterSearch::getParents($chapterId);
        $currentChapter['parents'] = $chapterParents;

        if( empty($currentChapter['cover']) )
            $currentChapter['cover'] = '/images/default.jpg';

        //$pointList     =   PointSearch::getListByChapterId($chapterId);
        $videoList     =   VideoSearch::getListByChapterId($chapterId);
        $materialList  =   MaterialSearch::getListByChapterId($chapterId);
        //$testPaperList =   CourseLessonSearch::getTestPaperListByChapter($chapterId);
        $articleList   =   ArticleSearch::getArticleListByChapterId($chapterId);
        $articleData   =   ArticleSearch::find()->where(['id'=>Yii::$app->request->get('aid')])->createCommand()->queryOne();
        ;
        $data = [
            'currentChapter'=>$currentChapter,
            'rootChapter'=>0,
            'videoList'=>$videoList,
           // 'pointList'=>$pointList,
            'materialList'=>$materialList,
           // 'testpaperList'=>$testPaperList,
            'articleList'=>$articleList,
            'articleData'=>$articleData,
            'join'=>false,
        ];

        return $this->asJson([ 'status'=>1 , 'data'=>$data ]);

    }

    /***
     * 视频列表
     * @return string
     */
    public function actionVideo()
    {
        $this->layout="index";
        $category = Yii::$app->request->get('category');
        $page     = Yii::$app->request->get('page' , 1);
        $pagesize = Yii::$app->request->get('pagesize',12);
        $keyword  = Yii::$app->request->get('keyword','');
        $keyword = substr($keyword,0,30);

        if(strrpos($category ,','))
            $category = substr($category , strrpos($category ,',')+1);

        $category = intval($category);
        $result = VideoSearch::getPageByCategory($category ,$page ,$pagesize,$keyword);
        $books  = $result['data'];
        $total  = $result['total'];
        $totalPage = intval( ($total-1)/$pagesize+1 );

        $categoryArray = [];
        $currentCategory =CategorySearch::find()->where(['id'=>$category])->asArray()->one();
        if($currentCategory['parentId'])
        {
            $parentCategory =CategorySearch::find()->where(['id'=>$currentCategory['parentId'] ])->asArray()->one();
            $categoryArray[] = $parentCategory;
        }
        $categoryArray[] = $currentCategory;

        $bookCategoryTree =  CategorySearch::getBookCategoryTree();
        $bookLvl1Category =  CategorySearch::getBooklvl1Category();
        $data= [
            'categoryTree'=>$bookCategoryTree,
            'bookLvl1Category'=>$bookLvl1Category,
            'totalPage'=>$totalPage ,
            'lists'=>$books,
            'currentCategorys'=>$categoryArray
        ];
        // var_dump($data); exit();
        return $this->render('video_list',$data);
    }

    /***
     *
     */
    public  function actionVideoDetail()
    {
        $this->layout = 'index';
        $id = Yii::$app->request->get('id');
        $model = Video::findOne(['id'=>$id]);

        //var_dump($model);
        if(empty($model))
            return $this->renderPartial('/site/error',['name'=>'资源问题','message'=>'视频暂时无内容']);
        $isCollect = false;
        if( ! Yii::$app->user->isGuest)
        {
            $uid =Yii::$app->user->id;
            if( User::isCollect($uid ,'video' ,$id))
                $isCollect = true;
        }
        $data = $model->getAttributes();
        $user = User::findOne(['id'=>$model['uid']]);
        $data['nickname'] = $user['nickname'];
        $data['userId'] = $data['uid'];
        $data['category'] =  CategorySearch::getTitlesByIdstr($data['category']);

        $comments =  UserSearch::getComments('video' ,$id );
        $comments = TreeUtils::list2tree($comments,'parentId');

        $danmus = [];
        return $this->render('/index/videoDetail' ,
            ['data'=>$data ,'danmus'=> json_encode($danmus) ,'isCollect'=>$isCollect ,'comments'=>$comments] );
    }

    /***
     * 资料列表
     * @return string
     */
    public function actionMaterial()
    {
        $this->layout="index";
        $category = Yii::$app->request->get('category');
        $page     = Yii::$app->request->get('page' , 1);
        $pagesize = Yii::$app->request->get('pagesize',12);
        $keyword  = Yii::$app->request->get('keyword','');
        $keyword = substr($keyword,0,30);

        if(strrpos($category ,','))
            $category = substr($category , strrpos($category ,',')+1);

        $category = intval($category);
        $result = MaterialSearch::getPageByCategory($category ,$page ,$pagesize ,$keyword);
        $books  = $result['data'];
        $total  = $result['total'];
        $totalPage = intval( ($total-1)/$pagesize+1 );

        $categoryArray = [];
        $currentCategory =CategorySearch::find()->where(['id'=>$category])->asArray()->one();
        if($currentCategory['parentId'])
        {
            $parentCategory =CategorySearch::find()->where(['id'=>$currentCategory['parentId'] ])->asArray()->one();
            $categoryArray[] = $parentCategory;
        }
        $categoryArray[] = $currentCategory;

        $bookCategoryTree =  CategorySearch::getBookCategoryTree();
        $bookLvl1Category =  CategorySearch::getBooklvl1Category();


        $data= [
            'categoryTree'=>$bookCategoryTree,
            'bookLvl1Category'=>$bookLvl1Category,
            'totalPage'=>$totalPage ,
            'lists'=>$books,
            'currentCategorys'=>$categoryArray
        ];
        // var_dump($data); exit();
        return $this->render('material_list',$data);
    }

    /***
     *
     */
    public  function actionMaterialDetail()
    {
        $this->layout = 'index';
        $id = Yii::$app->request->get('id');
        $model = Material::findOne(['id'=>$id]);

        //var_dump($model);
        if(empty($model))
            return $this->renderPartial('/site/error',['name'=>'资源问题','message'=>'视频暂时无内容']);
        $isCollect = false;
        if( ! Yii::$app->user->isGuest)
        {
            $uid =Yii::$app->user->id;
            if( User::isCollect($uid ,'material' ,$id))
                $isCollect = true;
        }
        $data = $model->getAttributes();
        $user = User::findOne(['id'=>$model['uid']]);
        $data['nickname'] = $user['nickname'];
        $data['userId'] = $data['uid'];
        $data['category'] =  CategorySearch::getTitlesByIdstr($data['category']);

        $comments =  UserSearch::getComments('material' ,$id );
        $comments = TreeUtils::list2tree($comments,'parentId');
        $danmus = [];
        return $this->render('/index/materialDetail' ,
            ['data'=>$data ,'danmus'=> json_encode($danmus) ,'isCollect'=>$isCollect,'comments'=>$comments] );
    }
    /***
     * 通知详情
     * @return string
     */
    public  function actionNotification()
    {
        $id = Yii::$app->request->get('id');
        $notification = NotificationSearch::findOne(['id'=>$id])->getAttributes();
        $this->layout = 'frontend';
        return $this->render( 'notification' ,['notification'=>$notification ]);
    }


    /***
     * 获取
     * @return string
     */
    public function actionCourse()
    {
        $this->layout=false;
        $list= CourseSearch::find()->select('id , title, subtitle as desc ,type, price,lessonNum ,tags ,userId ,middlePicture as cover ')->createCommand()->queryAll();
        foreach ($list as &$item)
        {
            $item['cover'] = str_replace('public:/' , '/files' ,$item['cover']);
        }

        $data= [ 'lists'=>$list ];

        return $this->render('course_list',$data);
    }

    /**
     * Lists all Album models.
     * @return mixed
     */
    public function actionMindex()
    {
         $this->layout = 'mobile';
        return $this->render('mindex',['isHideMenu'=>true]);
    }
    public function  actionGetIndex()
    {
        $hostArticle = PointQuery::getHot();
        $lastArticle = PointQuery::getLast();
        $fistArticle = PointQuery::getArticleList();
        $hosUser = PointQuery::getHotUser();
        //$t1 = microtime(true);
        $nav  =  Tag::getTagsByLvl(1);
        //$t2 = microtime(true);
        //echo round($t2-$t1,3);
        $carousel = PointQuery::getCarousel();
        // 最新文章  最热   首页文章  大侠
        $data= ['hotArticle'=>$hostArticle, 'lastArticle'=>$lastArticle,'nav'=>$nav,
            'fristArticle'=>$fistArticle['data'] , 'hotUser'=>$hosUser , 'carousel'=>$carousel];

       //return $this->render('index',['isHideMenu'=>true]);
        echo json_encode(['data'=>$data, 'status'=>1]);
    }

}
