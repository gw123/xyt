<?php

namespace frontend\controllers;

use common\models\User;
use frontend\listener\ArticleListener;
use Yii;
use common\models\Article;
use common\models\ArticleSearch;
use yii\base\Event;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use \Michelf\Markdown;

/**
 * ArticleController implements the CRUD actions for Article model.
 */
class ArticleController extends BaseHomeController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function __construct($id,  $module, array $config=[])
    {
        Event::on(ArticleListener::className(),ArticleListener::UPDATE, [ArticleListener::className(),'onUpdate']  );
        parent::__construct($id, $module, $config);
    }

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "",//图片访问路径前缀
                     // "imagePathFormat" =>"/files/default/{yyyy}{mm}{dd}/{time}{rand:6}" ,//上传保存路径
                     "imageRoot"=>Yii::$app->params['DataPath'],
                     "scrawlRoot"=>Yii::$app->params['DataPath'],
                     "videoRoot"=>Yii::$app->params['DataPath'],
                     "fileRoot"=>Yii::$app->params['DataPath'],
                     'xssFilterRules'=> false ,
                     'inputXssFilter'=> false ,//input xss过滤
                     'outputXssFilter' => false //output xss过滤
                ],
            ]
        ];
    }

    /***
     *   markdown 测试
     */
    public  function actionMarkdownPreview()
    {
        $content = Yii::$app->request->post('content');
        $my_html = Markdown::defaultTransform($content);
        echo json_encode(['status'=>1,'content'=>$my_html]);
    }

    /**
     * Lists all Article models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $condition =Yii::$app->request->queryParams;

        if(is_array($condition))
            $condition['ArticleSearch']['userId'] = Yii::$app->user->id;
        else
        {
            $condition= array();
            $condition['ArticleSearch']['userId'] = Yii::$app->user->id;
        }

        $dataProvider = $searchModel->search($condition);
        $this->pageTitle = '我的文章';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function  isSelf( $articleId)
    {
        if(empty($articleId)) return false;
        return Article::find()->where( ['userId'=>Yii::$app->user->id,'id'=>$articleId] )->one();
    }
    /***
     * 获取文章详情
     * @return array
     */
    public  function  actionDetail()
    {
        $id = Yii::$app->request->get('id',0);

        Yii::$app->response->format = Response::FORMAT_JSON;

        $article = self::findModel($id)->getAttributes();
        if($article)
        {
            return ['status'=>1 , 'data'=>$article];
        }
        return ['status'=>0 , 'msg'=>'获取内容为空'];
    }
    /**
     * Displays a single Article model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Article model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Article();
        $model->setScenario('create');
        $model->userId = Yii::$app->user->id;
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->createdTime = time();
            if($model->status == 'published')
             $model->publishedTime = time();

            if (  $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else{
               // var_dump($model->getErrors()); exit();
            }
        }
        $this->pageTitle = '写文章';
        return $this->render('create', [ 'model' => $model ]);
    }

    /**
     * Updates an existing Article model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        $model = $this->findModel($id);
        if ($model->load( Yii::$app->request->post() )  ) {

            $model->updatedTime = time();
            if($model->status == 'published')
            $model->publishedTime = time();

            $editor_type = Yii::$app->request->post('Article')['editor_type'];
            if( $editor_type == 'markdown')
            {
                $content = Yii::$app->request->post('Article')['markdown'];
                $makrdownHtml = Markdown::defaultTransform($content);
                //var_dump($makrdownHtml); exit();
                $model->body = $makrdownHtml;
            }
            if($model->save())
            {
                Event::trigger(ArticleListener::className(),ArticleListener::UPDATE);
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo "更新失败!!";
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Article model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        $model = $this->findModel($id);
        $model->status = Article::trash;
        if($model->save())
        {
            return $this->redirect(['index']);
        }else{
            return $this->renderPartial( '/site/error',['name'=>'删除失败' ,'message'=>''] );
        }
    }


    /****
     * 通过章节获取文章
     * @return array
     */
    public  function  actionGetArticleByChapter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data= Yii::$app->request->post('data');
        $chapterId  = intval($data['chapterId']);
        $sql = "select id ,title from article where chapter in({$chapterId}) limit 100";
        $list = Yii::$app->sphinx->createCommand($sql)->queryAll();

        return  ['status'=>1 ,'data'=>$list];
    }

    /***
     * 修改章节
     * @return array
     */
    public  function  actionChangeChapter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id' , '');
        $chapter = Yii::$app->request->get('chapter' , '');

        if(!$this->isSelf($id))
            return  ['status'=>0 , 'msg'=>'抱歉,这是其他人的资源'];
        if(empty($chapter ))
        {
            return[ 'status'=>0 ,'msg'=>'参数为空'];
        }

        $model = $this->findModel($id);

        $model->chapter = $chapter;
        $ret = [ 'status'=>0 ,'msg'=>'修改失败'];
        if($model->validate()&&$model->save())
        {
            $ret['status']= 1 ; $ret['msg']= '';
        }
        return $ret;
    }

    /***
     * 修改目录
     * @return array
     */
    public  function  actionChangeCategory()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->get('id' , '');
        $category = Yii::$app->request->get('category' , '');

        if(!$this->isSelf($id))
            return  ['status'=>0 , 'msg'=>'抱歉,这是其他人的资源'];

        if(empty($category ))
        {
            return[ 'status'=>0 ,'msg'=>'参数为空'];
        }

        //$categoryArr = explode(',' ,$category);
        //$categoryId = array_pop($categoryArr);
        $model = $this->findModel($id);
        $model->category = $category;
        //$model->categoryId = $categoryId;

        $ret = [ 'status'=>0 ,'msg'=>'修改失败'];
        if($model->validate()&&$model->save())
        {
            $ret['status']= 1 ; $ret['msg']= '';
        }
        return $ret;
    }


    /**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
