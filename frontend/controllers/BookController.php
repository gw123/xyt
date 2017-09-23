<?php

namespace frontend\controllers;

use Yii;
use common\models\Book;
use common\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Chapter;
use common\models\ChapterSearch;

use common\models\ArticleSearch;
use common\models\CourseLessonSearch;
use common\models\CourseSearch;
use common\models\MaterialSearch;
use common\models\PointSearch;
use common\models\VideoSearch;
use common\utils\Log;
/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends BaseHomeController
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
                   // 'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function  isSelf( $id)
    {
        if(empty($id)) return false;
        return Book::find()->where( ['userId'=>Yii::$app->user->id,'id'=>$id] )->one();
    }
    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $condition =Yii::$app->request->queryParams;

        if(is_array($condition))
            $condition['BookSearch']['userId'] = Yii::$app->user->id;
        else
        {
            $condition= array();
            $condition['BookSearch']['userId'] = Yii::$app->user->id;
        }

        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search($condition);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
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
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();
        $model->status ='published';
        $model->deveStatus = 'ondeve';
        if(Yii::$app->request->isPost)
        {
            $model->userId = Yii::$app->user->id;
            $model->createdTime = time();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionChapter()
    {
        $bookId = Yii::$app->request->get('id' , 10);
        $treeMap =         ChapterSearch::getBookChapterTree($bookId);
        $bookName = Book::findOne(['id'=>$bookId]);

        $data = [
            'treeMap' => $treeMap ,
            'bookName'=>$bookName,
            'bookId' => $bookId
        ];
        return $this->render('chapter' , $data );
    }

    public function actionChapterData()
    {
        $chapterId = Yii::$app->request->post('chapterId' , 0);
        $currentChapter = ChapterSearch::findOne(['id'=>$chapterId]);

        if(!$currentChapter)
          return $this->asJson([ 'status'=>0 , 'msg'=>'章节不存在' ]);

        $currentChapter = $currentChapter->getAttributes();
        $chapterParents = ChapterSearch::getParents($chapterId);
        $currentChapter['parents'] = $chapterParents;

        if( empty($currentChapter['cover']) )
            $currentChapter['cover'] = '/images/default.jpg';
        $articleList   =   ArticleSearch::getArticleListByChapterId($chapterId);
        $pointList     =   PointSearch::getListByChapterId($chapterId);
        $videoList     =   VideoSearch::getListByChapterId($chapterId);
        $materialList  =   MaterialSearch::getListByChapterId($chapterId);
        $testPaperList =   CourseLessonSearch::getTestPaperListByChapter($chapterId);

        ;
        $data = [
            'currentChapter'=>$currentChapter,
            'videoList'=>$videoList,
            'pointList'=>$pointList,
            'materialList'=>$materialList,
            'testpaperList'=>$testPaperList,
            'articleList'=>$articleList,
        ];
        return $this->asJson( [ 'status'=>1 , 'data'=>$data ] );
    }

    public function actionImportChapter()
    {
        $error='';

        $bookId = Yii::$app->request->get('id' , 10);
        $currrentRootName = ChapterSearch::getRootName($bookId);

        $data = [
            'bookName'=>$currrentRootName,
            'error'=>$error,
        ];
        return $this->render('importChapter' ,$data );
    }
    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        $model = $this->findModel($id);
        $model->updatedTime = time();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        $model = $this->findModel($id);
        $model->status = Video::trash;
        if($model->save())
        {
            return $this->redirect(['index']);
        }else{
            return $this->renderPartial( '/site/error',['name'=>'删除失败' ,'message'=>''] );
        }

    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
