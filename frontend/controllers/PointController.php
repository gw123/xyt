<?php

namespace frontend\controllers;

use Yii;
use common\models\Point;
use common\models\PointSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\filters\AccessControl;

/**
 * PointController implements the CRUD actions for Point model.
 */
class PointController extends BackendController
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create-ajax'],
                'rules' => [
                    [
                        'actions' => ['create-ajax'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
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
                ],
            ]
        ];
    }


    /**
     * Lists all Point models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PointSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Point model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Point model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Point();
        $model->createdTime = time();
        $model->updatedTime = time();
        $model->uid = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Point model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->updatedTime = time();
            $model->updateUid = YIi::$app->user->getId();

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            echo "更新失败"; exit();
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing Point model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Point model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Point the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Point::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /****
     * 通过章节获取文章
     * @return array
     */
    public  function  actionGetPointByChapter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data= Yii::$app->request->post('data');
        $chapterId  = intval($data['chapterId']);
        $sql = "select id ,title from point where chapter in({$chapterId})";
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
        if(empty($category ))
        {
            $ret = [ 'status'=>0 ,'msg'=>'参数为空'];
            return $ret;
        }

        $model = $this->findModel($id);
        $model->category = $category;

        $ret = [ 'status'=>0 ,'msg'=>'修改失败'];
        if($model->validate()&&$model->save())
        {
            $ret['status']= 1 ; $ret['msg']= '';
        }
        return $ret;
    }

    public  function  actionCreateAjax()
    {
        Yii::$app->response->format =  Response::FORMAT_JSON;
        $model =  new  Point();
        $data = Yii::$app->request->post('data');
        $data['id'] = intval($data['id']);
        if($model->load($data ,'') )
        {
            if( isset( $data['id'])&&!empty($data['id']) )
                $model->isNewRecord=false;
            else
                $model->isNewRecord =true;

            if( $model->save() )
            {
                $id =   $model->id;
                return  ['status'=>1,'data'=>['id'=>$id] ];
            };
        };

        return  ['status'=>0,'msg'=>'创建失败'];

    }

    public  function actionGetArticleList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $param = Yii::$app->request->post('data');
        //return [];
        //\common\utils\Log::info($param);
        $result=  PointQuery::getArticleList($param);

        $result['status']=1;
        return $result;
    }

    public  function actionGetArticleByTag()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $param = Yii::$app->request->post('data');

        $result=  PointQuery::getArticleList($param);

        $result['status']=1;
        return $result;
    }

    public  function actionGetArticleByHot()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $param['pagesize'] = 5;
        $result=  PointQuery::getArticleByHot($param);
        //exit();
        $result['status']=1;
        return $result;
    }

    public  function actionGetArticleDetal()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $param = Yii::$app->request->post('data');
        $data = $this->findModel($param['id'])->getAttributes();
        $result['status']=1;
        $result['data']= $data;
        return $result;
    }

}
