<?php

namespace frontend\controllers;

use common\models\Book;
use common\models\CategorySearch;
use Yii;
use common\models\Chapter;
use common\models\ChapterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
/**
 * ChapterController implements the CRUD actions for Chapter model.
 */
class ChapterController extends BaseHomeController
{
    private  $_error='';
    private  $_waring = [];
    private  $_pageOffset=0;
    private  $_bookId=0;
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
     * Lists all Chapter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChapterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $roots = ChapterSearch::getRoots();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'roots'=>$roots
        ]);
    }

    public function actionTest(){
        $sql = "select * from  chapter where lvl=1";
        $res = Yii::$app->db->createCommand($sql)->queryAll();
        //var_dump($res);
        $ctime = time();
        foreach ($res as $item)
        {
            $book['title'] = $item['title'];
            $book['cover'] = $item['cover'];
            $book['desc']   = $item['desc'];
            $book['category']   = $item['category'];
            $book['createdTime'] =$ctime;
            $book['status'] = 'published';
            $book['auditStatus'] = 'pass';
            $book['userId'] =1;
            $res = Yii::$app->db->createCommand()->insert('book',$book)->execute();
            if($res ==false)
            {   echo "创建book 失败";
                break;}
                $insertId = Yii::$app->db->getLastInsertID();
             $res=   Yii::$app->db->createCommand()->update('chapter' , ['bookId'=>$insertId] ,['root'=>$item['id'] ])->execute();
            if($res ==false)
            {  echo "更新章节失败";
                break;}

        }
    }
    /**
     * Displays a single Chapter model.
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
     * Creates a new Chapter model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Chapter();
        if ( $model->load(Yii::$app->request->post()) )
        {
            $model->root = $model->id;
            $model->lvl = 1;
            $model->order = 0;   $model->status = 1;
            $model->parents = $model->id;
            if( $model->save() )
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        $maxid =  Yii::$app->db->createCommand( "select max(id) as maxid from chapter" )->queryScalar();
        $maxid =  intval(($maxid+200)/200) * 200;
        $model->id = $maxid;

        return $this->render( 'create', [
            'model' => $model,
        ] );
    }

    /**
     * Updates an existing Chapter model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');
        if ($model->load(Yii::$app->request->post())) {

            if($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                echo "error";
            };

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Chapter model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * Finds the Chapter model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Chapter the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if ( ( $model = Chapter::findOne($id) ) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /***
     *  批量导入章节
     */
    public  function actionImportChapter()
    {
        $formData =  Yii::$app->request->post('data');
        $chapnterText =  isset($formData['chapterContent']) ?$formData['chapterContent'] :'' ;
        $bookId = isset($formData['bookId']) ?$formData['bookId'] :0 ;
        $pageOffset  =   isset($formData['pageOffset']) ?$formData['pageOffset'] :0 ;
        $this->_pageOffset = $pageOffset;
        $this->_bookId= $bookId;
        if(empty($bookId) || empty($chapnterText))
        {
            return  $this->asJson( ['status'=>0 ,'msg'=>'参数不全']);
        }

        $book  = Book::find(['id'=>$bookId]);
        if(empty($book))
        {   return  $this->asJson(['status'=>0 , 'msg'=>'没有这部书籍']);  }

        $chapterRoot = Chapter::findOne(['bookId'=>$bookId ,  'lvl'=>1]);
        if(empty($chapterRoot))
        {
            $chapterRoot = new Chapter();
            $maxid =  Yii::$app->db->createCommand( "select max(id) as maxid from chapter" )->queryScalar();
            $maxid =  intval(($maxid+200)/200) * 200;
            $chapterRoot->id = $maxid;
            $chapterRoot->root = $chapterRoot->id;
            $chapterRoot->lvl = 1;
            $chapterRoot->order = 0;   $chapterRoot->status = 1;
            $chapterRoot->parents =    strval($chapterRoot->id);
            $chapterRoot->bookId  =    $bookId;
            $chapterRoot->pdfpages = 1;
            $chapterRoot->title = $book['title'];
            $chapterRoot->category = $book['category'];
            //var_dump( $model->getAttributes() );
            if(! $chapterRoot->save() )
            {
                return $this->asJson(['status'=>0 , 'msg'=>'创建根节点失败']);
            }
        }


        $category = $chapterRoot['category'];

        $lines = explode( "\n" ,$chapnterText);
        $zhangRule = "/(第\d+?章) *(.*?) *(\d*) *$/";
        $nodeRule  = "/^((\d+?\.)+(\d+?)) *(.*?) *(\d*) *$/";
        $fuluRule  =  "/^附录(\w? .*?) *(\d*) *$/";
        $ignoreChapterRules = [ '/^实例.*/' ];
        $tree = []; $node = null;
        $lastlvl1Node = null;
        $lastlvl2Node = null;

        foreach ( $lines as $index=>$line)
        {
            $line = trim($line);

            if(preg_match($zhangRule ,$line ,$match))
            {
                $part_1 = $match[1];
                $part_2 = $match[2];
                $page = $match[3];
                if($page=='')
                {
                    $this->_waring[] =  " 第 ".($index+1)." 行 ,缺少页码 : ".$line;
                    $page =1;
                }

                $node = ['title'=> $part_1." ".$part_2 , 'pdfpages'=>$page , 'children'=>[]  ];
                $tree[] = $node;
                $lastlvl1Node = &$tree[ count($tree) -1];
            }elseif (preg_match($fuluRule ,$line ,$match))
            {
                $part_1 = "附录";
                $part_2 = $match[1];
                $page   = $match[2];
                if($page=='')
                {
                    $this->_waring[] =  " 第 ".($index+1)." 行 ,缺少页码 : ".$line;
                    $page =1;
                }
                $node = ['title'=> $part_1." ".$part_2 , 'pdfpages'=>$page , 'children'=>[]  ];
                $tree[] = $node;
                $lastlvl1Node = &$tree[ count($tree) -1];
            } else{
                if(preg_match($nodeRule, $line ,$match))
                {
                    $part_1 = $match[1];
                    $part_2 = $match[4];
                    $page   = $match[5];
                    if($page=='')
                    {
                        $this->_waring[] =  " 第 ".($index+1)." 行 ,缺少页码 : ".$line;
                        $page =1;
                    }
                    $chapter_ = $part_1;  //  1.1.1
                    $chapters =explode('.' , $chapter_);
                    $lvl = count($chapters);

                    if( $lvl ==2 )
                    {
                        $node =  [ 'title'=> $part_1." ".$part_2 , 'pdfpages'=>$page , 'children'=>[]  ];
                        $lastlvl1Node['children'][]= $node;
                        $lastlvl2Node = &$lastlvl1Node['children'][  count($lastlvl1Node['children']) -1 ];
                    }else if($lvl == 3){
                        //导入章节 , 不导入第三级
                        //$node =   ['title'=>$line   ];
                        //$lastlvl2Node['children'][]=$node;
                    }else{
                        $this->_error =  "请检查一下小节前格式是否有问题 ".$line;
                    }

                }else{

                    $errorFlag = true;
                    foreach ($ignoreChapterRules as $ignoreChapterRule)
                    {
                        if( preg_match($ignoreChapterRule , $line , $match) )
                        {
                            $errorFlag =false;
                            break;
                        }
                    }
                    if($errorFlag)
                    {
                        $lineNo = $index+1;
                        $this->_error = " 第{$lineNo}行 ,格式有问题  :  ".$line;
                    }

                }
            }
        }

        $root['title'] = 'root';
        $root['lvl'] = 1;
        $root['pdfpages'] = 1;
        $root['children'] = $tree;
        $count=0;

        $this->tree2list($root ,$lvl =1 , 0 , $chapterRoot['id'] ,$count);

        if($this->_error)
        {
            return $this->asJson(['status'=>0 , 'msg'=>$this->_error]);
        }

        Yii::$app->db->createCommand()->update('chapter' ,[ 'category'=>$category ,'bookId'=>$bookId] , [ 'root'=>$chapterRoot['id'] ])->execute();
        //echo Yii::$app->db->createCommand()->update('chapter' ,[ 'category'=>$category ] , [ 'root'=>$rootChapterId ])->getRawSql();
        echo json_encode(['status'=>1 , 'msg'=>'success' , 'waring'=>$this->_waring]);  return;
    }

    /***
     * 将树转为列表 并且入库
     * @param $node
     * @param int $lvl
     * @param int $parentid
     * @param int $root
     * @param int $count
     * @param string $parents
     */
    function tree2list($node  ,$lvl=1 , $parentid=0 , $root =0,&$count=0 , $parents='')
    {
        //echo " lvl: {$lvl} :$count  parentId: {$parentid}  =>".$node['title']."\n";
        $insertItem = ['lvl'=>$lvl , 'title'=>$node['title'] ,'pdfpages'=>$node['pdfpages'] ,'root'=>$root ,'parentid'=>$parentid ,'status'=>1 ,'order'=>$count ];
        if($parentid==0)
        {
            //根节点
            $insertId = $root;
            $insertItem['parents'] = $root;
        }else{
            $insertItem['id'] = $root+$count;
            $insertItem['parents'] = $parents.",".$insertItem['id'];
            $insertId =   $this->insertNode($insertItem);
           // echo $item['id']." => $insertId \n";
        }

        if(isset($node['children']))
        {
            foreach ($node['children'] as $index=>$item)
            {
                $count++;
                $this->tree2list($item,$lvl+1 , $insertId ,$root ,$count , $insertItem['parents']);
            }
        }
    }

    /***
     * 插入一个节点, 到数据库
     * @param $node
     * @return string
     */
    function insertNode($node)
    {
        if($this->_pageOffset)
        {
            $node['pdfpages'] =  intval($node['pdfpages']) + $this->_pageOffset;
            $node['bookId'] = $this->_bookId;
        }

        if( ChapterSearch::findOne( ['id'=>$node['id']] ) )
        {
              if(Yii::$app->db->createCommand()->update('chapter' , $node ,['id'=>$node['id']] )->execute()!==false)
              {
                  return $node['id'];
              }else{
                  $this->_error = Yii::$app->db->createCommand()->update('chapter' , $node ,['id'=>$node['id']] )->rawSql;
                  return false;
              }

        }else{
              Yii::$app->db->createCommand()->insert('chapter' , $node )->execute();
            return Yii::$app->db->lastInsertID;
        }
    }

    /***
     * 管理章节树
     * @return string
     */
    public  function  actionRootManage()
    {
        $chapterRootId = Yii::$app->request->get('chapterRootId' , 10);
        $categoryId = Yii::$app->request->get('categoryId' ,0);
        //$this->layout = false;
        $chapterList =  ChapterSearch::getChapterList($chapterRootId);
        $treeMap = ChapterSearch::getTreeMap($chapterRootId);
        $currrentRootName = ChapterSearch::getRootName($chapterRootId);
        if(empty($categoryId))
         $rootChapters = ChapterSearch::getRoots();
        else
         $rootChapters = ChapterSearch::getRootChapterMapByCateogry($categoryId);

        $data = [
            'chapterList'=>$chapterList,
            'treeMap' => $treeMap ,
            'chapterRootId'=>$chapterRootId,
            'chapterRootName'=>$currrentRootName,
            'rootChapters' =>$rootChapters,
            'categoryId'=>$categoryId,
        ];
        return $this->render('tree' , $data );
    }

    /***
     * 根据目录获取目录下的书册 ajax
     * @return array
     */
    public function actionGetRootChapterByCategory()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $category = Yii::$app->request->get('category',0);
        $rootChapterMap = ChapterSearch::getRootChapterMapByCateogry($category);
        return ['status'=>1 ,'data'=>$rootChapterMap];
    }

    /*
    ****
    * 获取父章节下面的一级子章节
    */
    public  function  actionGetChapterSons()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $parentid = Yii::$app->request->get('parentid' , 1);
        $sons = Chapter::getChaptersByParent($parentid);
        //var_dump($sons);
        return ['status'=>1 , 'data'=>$sons];
    }

    public  function  actionUpdateChapterNode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $param =  \Yii::$app->request->post('data');
        $error='';
        isset($param['id'])  ? $condition['id']  = $param['id']:$error='请求格式错误';
        isset($param['title'])? $condition['title'] = $param['title']:$error='请求格式错误';

        if($error!='')    {    $ret = ['status'=>0,'msg'=>$error]; return $ret;  }

        $one = Chapter::findOne([ 'id'=>$param['id'] ]);
        if($one)
        {
            $one->title = $param['title'];
            if($one->save())
                return   $ret = ['status'=>1,'msg'=>'更新成功'];
        }else{
            return $ret = ['status'=>0,'msg'=>'更新数据不存在'];
        }

        return $ret = ['status'=>0,'msg'=>'更新失败'];
    }

    //修改页码
    public  function  actionModifyPageNum()
    {
        $chapterId =  intval( Yii::$app->request->post('id') );
        $pages      = Yii::$app->request->post('pages');
        if(empty($pages)||empty($chapterId))
            return json_encode(['status'=>0 ,'info'=>'修改失败']);

        if( !preg_match('/^[\d-,]+$/' ,$pages) )
        {
            return json_encode(['status'=>0 ,'info'=>'内容包含非法字符']);
        }
        $pageNumArr  =[];
        if(strpos($pages,'-'))
        {
            $ps = explode('-',$pages);
            if(count($ps)!==2) { return json_encode(['status'=>0 ,'info'=>'只能有一个 "-" ']); }
            $start = $ps[0];
            $end = $ps[1];
            if($start>$end){  return json_encode(['status'=>0 ,'info'=>'开始页码不能大于结束页码']); }
            for ( $i=$start ; $i<=$end ;$i++ )
            {
              $pageNumArr []= $i;
            }

        }else if( strrpos($pages ,',') )
        {
            $pageNumArr = explode(',',$pages);
        }else{
            $pageNumArr []= $pages;
        }
        $pagesStr = implode(',',$pageNumArr);
        foreach ($pageNumArr as $value)
        {
            $value = intval($value);
            if(empty($value)) { return json_encode(['status'=>0 ,'info'=>'页码只能为数字']); }
        }
        $res= Yii::$app->db->createCommand()->update('chapter' ,['pdfpages'=>$pagesStr],['id'=>$chapterId] )->execute();
        if($res===false)
        {
            return json_encode(['status'=>0 ,'info'=>'修改失败']);
        }else{
            return json_encode(['status'=>1 ,'info'=>'修改成功']);
        }
    }
    /***
     * 创建非根章节
     * @return array
     */
    public  function  actionCreateChapterNode()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $param =  \Yii::$app->request->post('data');
        $error='';
        isset($param['parentid'])  ? $condition['parentid']  = intval($param['parentid']) :$error='请求格式错误';
        isset($param['root'])      ? $condition['root'] = intval($param['root'])           :$error='请求格式错误';
        //创建
        if( $condition['parentid']==0 && $condition['root']==0 )
        {
            return ['status'=>0 , 'msg'=>'请选择父节点'];
        }
        if($error!='')    {    $ret = ['status'=>0,'info'=>$error]; return $ret;  }

        $parent =  self::findModel($condition['parentid']);
        //父节点存在
        if( $parent )
        {
            $sql = "select max(id) from chapter where root={$condition['root']}";
            $maxId = Yii::$app->db->createCommand($sql)->queryScalar();
            //echo $maxId; exit();
            $condition['order']= 1;
            $condition['status']=1;
            $condition['id'] = $maxId+1;
            $condition['lvl'] = $parent['lvl']+1;
            $condition['parents'] = $parent['parents'].",".$condition['id'];
            $condition['title'] = $param['name'];
            $condition['root'] = $parent['root'];
            $res = \Yii::$app->db->createCommand()->insert('chapter',$condition)->execute();
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
            $ret['data']['parents']=$condition['parents'];
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
        $current =   Chapter::findOne(['id'=>$id]);
        if( $current['lvl']==1 )
        {   //判断当前节点是否为根节点
            return ['status'=>0 ,'msg'=>'不能拖动根节点'];
        }

        $parent =   Chapter::findOne(['id'=>$parentId]);
        if($parent)
        {
            $item['id'] = $id;
            $item['parentId'] = $parentId;
            $item['lvl'] = $parent['lvl']+1;
            $item['parents'] = $parent['parents'].",".$id;

            $res =Yii::$app->db->createCommand()->update('chapter' ,$item,['id'=>$id] )->execute();
            if($res!==false)
            {
                return ['status'=>1 ];
            }
        }
        return ['status'=>0 , 'msg'=> '父节点设置有误'.$parentId];
    }

}
