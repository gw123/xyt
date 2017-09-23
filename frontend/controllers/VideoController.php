<?php

namespace frontend\controllers;

use Yii;
use common\models\Video;
use common\models\VideoSearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for Video model.
 */
class VideoController extends BaseHomeController
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
                   // 'delete' => ['POST'],
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
        return Video::find()->where( ['uid'=>Yii::$app->user->id,'id'=>$id] )->one();
    }

    /**
     * Lists all Video models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoSearch();

        $condition =Yii::$app->request->queryParams;

        if(is_array($condition))
            $condition['VideoSearch']['uid'] = Yii::$app->user->id;
        else
        {
            $condition= array();
            $condition['VideoSearch']['uid'] = Yii::$app->user->id;
        }

        $dataProvider = $searchModel->search($condition);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }




    /**
     * Displays a single Video model.
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
     * Creates a new Video model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Video();
        $model->createdTime = time();
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
     * Updates an existing Video model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        if(!$this->isSelf($id))
            return $this->renderPartial('/site/authError');

        $model = $this->findModel($id);
        //var_dump($model->getAttributes());
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            $model->updatedTime = time();
            $model->updateUid = YIi::$app->user->getId();

            if ($model->save()) {
                //var_dump( $model->getAttributes() ); exit();
                return $this->redirect(['view', 'id' => $model->id]);
            }

           // echo "更新失败"; exit();
        }


        //var_dump($model->getAttributes()); exit();
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Video model.
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
     * Finds the Video model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Video the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Video::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /***
     * 播放指定的视屏资源
     */
    public  function  actionPlayer()
    {
        $id  = Yii::$app->request->get('id' , 1000);
        $id  = intval($id);
        $this->layout = false;
        try{
            $video = $this->findModel($id)->getAttributes();
        }catch (Exception $e)
        {
            return $this->render('player', [ 'model' => []]);
        }
        $sql = "select content from video_danmu  where  videoId={$id} ";
        $danmus = Yii::$app->db->createCommand($sql)->queryColumn();
        $danmus = implode(',' ,$danmus);
        Yii::$app->session->set('currentVideoId' , $id);
        return $this->render('player', [ 'model' => $video , 'danmus'=>$danmus]);

    }

    /***
     * 发送檀木
     */
    public  function  actionPostDanmu()
    {
        //var_dump($_POST);
        $danmu = Yii::$app->request->post('danmu');
        $uid = Yii::$app->user->id;
        $createdTime = time();
        $videoId = Yii::$app->session->get('currentVideoId');
        $data = [
            'content'=>$danmu ,
            'uid'=>$uid,
            'createdTime'=>$createdTime,
            'videoId'=>$videoId
        ];

        if( Yii::$app->db->createCommand()->insert('video_danmu',$data)->execute() )
        {
            echo 'SUCESS';
        }else{
            echo '0';
        };
    }

    /***
     * 获取檀木
     */
    public  function  acitonGetDanmu()
    {
        var_dump($_GET);
    }

    /****
     * 通过章节获取文章
     * @return array
     */
    public  function  actionGetVideoByChapter()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data= Yii::$app->request->post('data');
        $chapterId  = intval($data['chapterId']);
        $sql = "select id ,title from video where chapter in({$chapterId})";
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
//http://player.youku.com/embed/XMjY3MzgzODg0
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
