<?php

namespace frontend\controllers;

use Yii;
use common\models\Exam;
use common\models\ExamSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\utils\Constant;
use yii\data\Pagination;
use common\models\Chapter;

/**
 * ExamController implements the CRUD actions for Exam model.
 */
class ExamController extends BackendController
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

    /**
     * Lists all Exam models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExamSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exam model.
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
     * Creates a new Exam model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Exam();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Exam model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());

        if ($model->load(Yii::$app->request->post()) && $model->save() ) {
            //var_dump($model); exit;
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $chapterTree = Chapter::getChapter();
        return $this->render('update', [
        'model' => $model,
          'chapterTree'=> json_encode($chapterTree)
        ]);
    }

    /**
     * Deletes an existing Exam model.
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
     * Finds the Exam model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Exam the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exam::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

   /*
    *   测试
    * */
    public  function  actionTest()
    {
       // $questionModel = new  \common\models\Question();
        //$q =  \common\models\Question::find()->limit(5)->asArray()->all();
        //var_dump($q);
        //return     $this->render('test');
        word2html('D:/www/tool/6.docx','D:/www/tool/6.html');
    }

    public  function  actionList()
    {
        // $questionModel = new  \common\models\Question();
        //$q =  \common\models\Question::find()->limit(5)->asArray()->all();
        //var_dump($q);
        $qlist = \common\models\Question::getList();
        return     $this->render('list',['questionList'=>$qlist]);
    }

    /*异步获取试题数据*/
    public  function  actionGetQuestion()
    {
        $questionModel = new  \common\models\Question();
        $q =  \common\models\Question::find()->select("*")
            ->join('INNER JOIN','question_text','question_text.question_id=question.id')
            ->where('question_from=18')
            ->limit(10)->asArray()->all();

        return json_encode($q);
    }

    //手机上显示的试卷列表
    public  function  actionMlist()
    {
        $this->layout = 'mobile';
        $condition = [];
        $query=  Exam::find()->select('id,title,intro,start_time,end_time,cover')->where($condition);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count() , 'pageSize'=>6]);
        //$pages->setPageSize(7);
        $models = $query->offset( $pages->offset )
            ->limit( $pages->limit )
            ->asArray()
            ->all();

        return $this->render('mobile/mlist.php', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    //试卷详情
    public  function  actionMexamDetal()
    {
        $this->layout = 'mobile';
        $id = Yii::$app->request->get('id');
        $qlist = \common\models\Question::getList($id);
        $map = [1=>'一',2=>'二' , 3=>'三',4=>'四',5=>'五',6=>'六',7=>'七'];
        $big_item = [];
        foreach ($qlist as  $index=>$q)
        {
            $big_pos = intval(substr($q['position'],0,2));
            $sub_order = intval(substr($q['position'],2,2));
            $q['position'] = $sub_order;
            $big_item[$big_pos]['items'][$sub_order] = $q;
            $big_item[$big_pos]['desc'] = $map[$big_pos]."，".Constant::$QUESTION_TYPES[$q['type']];
        }
        //var_dump($big_item); exit;

        return     $this->render('./mobile/mExamDetal.php',['questionList'=>$big_item]);
    }

}


