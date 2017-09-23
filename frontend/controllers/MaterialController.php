<?php

namespace frontend\controllers;

use common\models\Chapter;
use common\models\ChapterSearch;
use Yii;
use common\models\Material;
use common\models\MaterialSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\utils\Log;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends BaseHomeController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                  //  'delete' => ['POST'],
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

    public function  isSelf( $id)
    {
        if(empty($id)) return false;
        return Material::find()->where( ['uid'=>Yii::$app->user->id,'id'=>$id] )->one();
    }

    /**
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialSearch();
        $condition =Yii::$app->request->queryParams;

        if(is_array($condition))
            $condition['MaterialSearch']['uid'] = Yii::$app->user->id;
        else
        {
            $condition= array();
            $condition['MaterialSearch']['uid'] = Yii::$app->user->id;
        }

        $dataProvider = $searchModel->search($condition);
        $this->pageTitle = '我的资料';
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Material model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');
        $this->pageTitle = '查看';
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Material();
        $model->createdTime = time();
        $model->updatedTime  = time();
        $model->uid = Yii::$app->user->getId();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [ 'model' => $model ]);
    }

    /**
     * Updates an existing Material model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');
        $model = $this->findModel($id);

        if(Yii::$app->request->isPost)
        {

            $model->load(Yii::$app->request->post());
            $model->updatedTime = time();

            if ($model->save()) {
                 //
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->redirect(['update', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing Material model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');


        $model = $this->findModel($id);
        $model->status = Material::trash;
        if($model->save())
        {
            return $this->redirect(['index']);
        }else{
            return $this->renderPartial( '/site/error',['name'=>'删除失败' ,'message'=>''] );
        }
    }

    /**
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /****
     * 通过章节获取文章
     * @return array
     */
    public  function  actionGetMaterialByChapter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data= Yii::$app->request->post('data');
        $chapterId  = intval($data['chapterId']);
        $sql = "select id ,title from material where chapter in({$chapterId})";
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
        if(!$this->isSelf($id))
            return  ['status'=>0 , 'msg'=>'抱歉,这是其他人的资源'];

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
        if(!$this->isSelf($id))
            return  ['status'=>0 , 'msg'=>'抱歉,这是其他人的资源'];

        $category = Yii::$app->request->get('category' , '');
        if(empty($category ))
            return [ 'status'=>0 ,'msg'=>'参数为空'];


        $model = $this->findModel($id);
        $model->category = $category;

        $ret = [ 'status'=>0 ,'msg'=>'修改失败'];
        if($model->validate()&&$model->save())
        {
            $ret['status']= 1 ; $ret['msg']= '';
        }
        return $ret;
    }
}
