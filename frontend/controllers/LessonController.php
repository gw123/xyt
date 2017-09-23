<?php

namespace frontend\controllers;

use Yii;
use common\models\CourseLesson;
use common\models\CourseLessonSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * LessonController implements the CRUD actions for CourseLesson model.
 */
class LessonController extends BackendController
{

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
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all CourseLesson models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CourseLessonSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CourseLesson model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new CourseLesson model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CourseLesson();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CourseLesson model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CourseLesson model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CourseLesson model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return CourseLesson the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CourseLesson::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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

}
