<?php

namespace frontend\controllers;

use Yii;
use common\models\Category;
use common\models\CategorySearch;
use yii\base\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends BaseHomeController
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
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $rootCategorys = CategorySearch::getRootCategorys();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'rootCategorys'=>$rootCategorys
        ]);
    }

    /**
     * Displays a single Category model.
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
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Category model.
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
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        if( $model->save() )
            return $this->redirect(['index']);
    }

    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public  function  actionTreeManage()
    {
        $rootId = Yii::$app->request->get('id' , 10);
        //$this->layout = false;
        $treeMap = CategorySearch::getTreeMap($rootId);
        $categoryRootName = CategorySearch::getRootName($rootId);
        $treeMap = json_encode($treeMap);
        //var_dump($treeMap);
        $data = [
            'treeMap' => $treeMap ,
            'categoryRootId'=>$rootId,
            'categoryRootName'=>$categoryRootName
        ];
        return $this->render('tree' , $data );
    }

    /***
     * 获取父章节下面的子章节
     */
    public  function  actionGetCategorySons()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $parentid = Yii::$app->request->get('parentid' , 1);
        $sons = CategorySearch::getCategorysByParent($parentid);
        //var_dump($sons);
        return ['status'=>1 , 'data'=>$sons];
    }


    public  function  actionUpdateNode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $param =  \Yii::$app->request->post('data');
        $error='';
        isset($param['id'])  ? $condition['id']  = $param['id']:$error='请求格式错误';
        isset($param['title'])? $condition['title'] = $param['title']:$error='请求格式错误';

        if($error!='')    {    $ret = ['status'=>0,'msg'=>$error]; return $ret;  }
        $one=  $this->findModel($param['id']);

        if($one)
        {
            $one->name = $param['title'];
            if($one->save())
                return   $ret = ['status'=>1,'msg'=>'更新成功'];
        }else{
            return $ret = ['status'=>0,'msg'=>'更新数据不存在'];
        }

        return $ret = ['status'=>0,'msg'=>'更新失败'];
    }

    /***
     * 创建非根章节
     * @return array
     */
    public  function  actionCreateNode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $param =  \Yii::$app->request->post('data');
        $error='';
        isset($param['parentid'])  ? $condition['parentid']  = intval($param['parentid']) :$error='请求格式错误';
        //创建
        if( $condition['parentid']==0 && $condition['root']==0 )
        {
            return ['status'=>0 , 'msg'=>'请选择父节点'];
        }
        if($error!='') {  $ret = ['status'=>0,'info'=>$error]; return $ret;  }

        $parent =  self::findModel($condition['parentid']);
        //父节点存在
        if( $parent )
        {
            $condition['status']=1;
            $condition['lvl'] = $parent['lvl']+1;
            $condition['name'] = $param['name'];
            $condition['groupId'] = $parent['groupId'];
            $condition['code'] = time();
            //var_dump($condition); exit();
            $res = \Yii::$app->db->createCommand()->insert('category',$condition)->execute();
            $newId = \Yii::$app->db->getLastInsertID();
        }
        //注意分配章节溢出的情况 , 默认情况下一个根章节下面可以有500ge子章节
        $ret = ['status'=>0,'msg'=>'失败'];
        if($res)
        {
            $ret['status'] =1;
            $ret['msg'] = 'success';
            $ret['data']['id']=$newId;
            $ret['data']['lvl']=$condition['lvl'];
            return $ret;
        }
        return $ret;
    }

    /****
     * 移动节点
     * @return array
     */
    public function  actionMoveNode()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $data = Yii::$app->request->post('data');
        $id =       intval( $data['id'] );
        $parentId = intval( $data['parentId']);
        $current =   self::findModel( $id );
        if(!$current)
        {   //判断当前节点是否为根节点
           return ['status'=>0 ,'msg'=>'数据出错 , 节点不存在!'];
        }

        $parent =    self::findModel( $parentId);
        if($parent)
        {
           // $item['id'] = $id;
            $item['parentId'] = $parentId;
            $item['lvl'] = $parent['lvl']+1;
           // $item['parents'] = $parent['parents'].",".$id;
            $res =Yii::$app->db->createCommand()->update('category' ,$item,['id'=>$id] )->execute();
            if($res!==false)
            {
                return ['status'=>1 ];
            }
        }
        return ['status'=>0 , 'msg'=> '父节点设置有误'.$parentId];
    }
}
