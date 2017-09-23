<?php
namespace frontend\controllers;
use Yii;
use yii\base\Exception;
use yii\helpers\FileHelper;
use yii\web\Response;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\db\Query;
//use yii\widgets\ActiveForm;

use common\models\UserSearch;
use common\models\User;
use kartik\form\ActiveForm;

class UserController extends BaseHomeController
{
    /*
     * 用户管理
     */
    public function actionIndex()
    {
        if(Yii::$app->user->isGuest)
        {
            //return $this->asJson( ['status'=>'3' , 'msg'=>'请登陆'] );
            return $this->redirect('/site/login');
        }

        $this->pageTitle = '用户资料';
        $uid = Yii::$app->request->get('uid');
        $isSelf = false;
        $isCollect = false;
        /** 如果没有传其他用户的id*/
        if(empty($uid)||$uid==Yii::$app->user->id)
        {
            $uid = Yii::$app->user->id;
            $isSelf = true;
        }else{
            $isCollect = User::isCollect( Yii::$app->user->id,'user',$uid );
        }

        $baseInfo = Yii::$app->db->createCommand("select nickname ,mediumAvatar from  user where id ={$uid} ")->queryOne();
        $baseInfo['mediumAvatar'] = $baseInfo['mediumAvatar'] ? $baseInfo['mediumAvatar']:Yii::$app->params['defaultAvatar'];
        $setting = Yii::$app->db->createCommand( 'select * from user_profile where id='.$uid )->queryOne();
        if(!empty($setting))
            $setting = array_merge($setting ,$baseInfo);
        else
        {
            $setting =$baseInfo;
                        $setting['city'] = '未设置';
            $setting['birthday'] = '未设置';
            $setting['interest'] = '未设置';
            $setting['weibo'] = '未设置';
            $setting['signature'] = '未设置';
            $setting['about'] = '未设置';

        }
 	
        $setting['uid'] = $uid;
        foreach ($setting as &$value)
        {
            if(empty($value)) $value="<small>未设置</small>";
        }

        $userAbout = [];
        $recentActivity = [];
        $sortArray = [];
        $sql = "select count(*) from book where userId ={$uid}";
        $total = Yii::$app->db->createCommand($sql)->queryScalar();
        //$timeLimit = time() - 360*24*3600;
        $timeLimit =  0;
        $userAbout['bookTotal']= $total;
        if($total)
        {
            $sql = "select id,title ,createdTime from book where userId ={$uid}  and createdTime >$timeLimit order by createdTime desc limit 5";
            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            //$userAbout['bookList'] = $rows;
            if(!empty($rows))
            {
                foreach ($rows as $row)
                {
                    $row['createdTime'] = date('Y-m-d h:i:s' ,$row['createdTime']);
                    $row['type'] = '书籍';
                    $row['href'] = "/index/book-detail?id=".$row['id'];
                    $recentActivity[]=$row;
                    $sortArray[] = $row['createdTime'];
                }
            }
        }

        $sql = "select count(*) from article where userId ={$uid}";
        $total = Yii::$app->db->createCommand($sql)->queryScalar();
        $userAbout['articleTotal'] = $total;

        if($total)
        {
            $sql = "select id,title ,createdTime from article where userId ={$uid} and createdTime >$timeLimit order by createdTime desc limit 5";
            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            //$userAbout['articleList'] = $rows;
            if(!empty($rows))
            {
                foreach ($rows as $row)
                {
                    $row['createdTime'] = date('Y-m-d h:i:s' ,$row['createdTime']);
                    $row['type'] = '文章';
                    $row['href'] = "/index/article-detail?id=".$row['id'];
                    $recentActivity[]=$row;
                    $sortArray[] = $row['createdTime'];
                }
            }
        }

        $sql = "select count(*) from video where uid ={$uid}";
        $total = Yii::$app->db->createCommand($sql)->queryScalar();
        $userAbout['videoTotal'] = $total;
        if($total)
        {
            $sql = "select id,title ,createdTime from video where uid ={$uid} and createdTime >$timeLimit order by createdTime desc limit 5";
            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            //$userAbout['videoleList'] = $rows;
            if(!empty($rows))
            {
                foreach ($rows as $row)
                {
                    $row['createdTime'] = date('Y-m-d h:i:s' ,$row['createdTime']);
                    $row['type'] = '视频';
                    $row['href'] = "/index/video-detail?id=".$row['id'];
                    $recentActivity[]=$row;
                    $sortArray[] = $row['createdTime'];
                }
            }
        }

        $sql = "select count(*) from material where uid ={$uid}";
        $total = Yii::$app->db->createCommand($sql)->queryScalar();
        $userAbout['materialTotal'] = $total;
        if($total)
        {
            $sql = "select id,title ,createdTime from material where uid ={$uid} and createdTime >$timeLimit order by createdTime desc limit 5";
            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            //$userAbout['materialList'] = $rows;
            if(!empty($rows))
            {
                foreach ($rows as $row)
                {
                    $row['createdTime'] = date('Y-m-d h:i:s' ,$row['createdTime']);
                    $row['type'] = '资料';
                    $row['href'] = "/index/material-detail?id=".$row['id'];
                    $recentActivity[]=$row;
                    $sortArray[] = $row['createdTime'];
                }
            }
        }
        // 安装时间排序
        array_multisort($sortArray,SORT_DESC ,$recentActivity);

        $sql = "select count(*) from user_collection where   type='user' and cid={$uid}";
        $total = Yii::$app->db->createCommand($sql)->queryScalar();
        $userAbout['followTotal'] = $total;

        return $this->render('index' , ['userAbout'=>$userAbout,'recentActivity'=>$recentActivity,'setting'=>$setting ,'isSelf'=>$isSelf ,'isCollect'=>$isCollect] );
    }

    /***
     * 取消收藏
     * @param $type
     * @param $cid
     * @return string|Response
     */
    public function  actionCancelCollect($type,$cid)
    {
        $types = ['article' , 'point' , 'book','video','material','lesson','user'];
        if(!in_array($type ,$types) )
        {
            return " <script> history.back() </script> ";
            //return $this->asJson( ['status'=>'2' , 'msg'=>'类型检测出错'] );
        }

        if(empty($cid))
        {
            //return $this->asJson( ['status'=>'2' , 'msg'=>'收藏内容有问题'] );
            return " <script> history.back() </script> ";
        }

        if(Yii::$app->user->isGuest)
        {
            //return $this->asJson( ['status'=>'3' , 'msg'=>'请登陆'] );
            return $this->redirect('/site/login');
        }

        try{
            $res = User::cancelCollect(Yii::$app->user->id ,$type,$cid );
            // return $this->asJson( ['status'=>'1' ] );
            return " <script> history.back() </script> ";
        }catch ( Exception $e)
        {
            //$errorMsg = $e->getMessage(); echo $errorMsg;
           // return $this->asJson( ['status'=>'6' , 'msg'=> '失败' ] );
            return " <script> history.back() </script> ";
        }
    }

    public function actionMyCollection()
    {
        $type = Yii::$app->request->get('type','article');
        $page =Yii::$app->request->get('page',1 );
        $filter = ['book' ,'article','video','material'];
        if(!in_array($type,$filter))
        {
            return $this->render('collection' ,['rows'=>[] , 'type'=>$type]);
        }
        $uid = Yii::$app->user->id;
        $result= UserSearch::getUserCollect($uid,$type ,$page);
        //var_dump($result); exit();
        return $this->render('collection' ,['rows'=>$result['rows'] , 'type'=>$type ,'total'=>$result['total']]);
    }

    /***
     * 收藏
     * @param $type
     * @param $cid
     * @return string
     */
    public function  actionCollection($type ,$cid)
    {
         $types = ['article' , 'point' , 'book','video','material','lesson','user'];
         if(!in_array($type ,$types) )
         {
             return " <script> history.back() </script> ";
             //return $this->asJson( ['status'=>'2' , 'msg'=>'类型检测出错'] );
         }

         if(empty($cid))
         {
             // return $this->asJson( ['status'=>'2' , 'msg'=>'收藏内容有问题'] );
             return " <script> history.back() </script> ";
         }

         if(Yii::$app->user->isGuest)
         {
             // return $this->asJson( ['status'=>'3' , 'msg'=>'请登陆'] );
             return " <script> history.back() </script> ";
         }


        try{
            $res = User::collect(Yii::$app->user->id ,$type,$cid );
            if($res)
            {

                return " <script> history.back() </script> ";
                //return $this->asJson( ['status'=>'1' ] );
            }else{
                return " <script> history.back() </script> ";
                //return $this->asJson( ['status'=>'4' ] );
            }

        }catch ( Exception $e)
        {
            $errorMsg = $e->getMessage();
            if(strpos($errorMsg , 'Duplicate entry')!==false)
            {
                return " <script> history.back() </script> ";
                //return $this->asJson( ['status'=>'1' , 'msg'=> '已经收藏' ] );
            }else{
                return " <script> history.back() </script> ";
                //return $this->asJson( ['status'=>'6' , 'msg'=> '系统异常' ] );
            }

        }

    }

    /**
     * ajax验证是否存在
     * @return array
     */
    public function actionAjaxvalidate()
    {
        $model = new User();
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model, 'username');
        }
    }

    /***
     * 评论接口
     * @return Response
     */
    public function actionComment()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->asJson( ['status'=>5 ,'msg'=>'未登录'] );
        }
        $toId = Yii::$app->request->post('toId');
        $type = Yii::$app->request->post('type');
        $content = Yii::$app->request->post('content');
        $content = htmlspecialchars($content);
        $parentId = Yii::$app->request->post('parentId',0);
        $parentId = intval($parentId);
        $toId = intval($toId);

        if($parentId){
            $sql = "select user.nickname ,userId ,parentId ,content from comment inner join user on user.id=comment.userId where comment.id=".$parentId." limit 1";
            $parentItem =Yii::$app->db->createCommand($sql)->queryOne();

            if(!empty($parentItem))
            {
                if($parentItem['parentId']!=0)
                {
                    $content = "//@".$parentItem['nickname']."#".mb_substr($parentItem['content'],0,12)."#".$content;
                    $parentId = $parentItem['parentId'];
                }

            }else{

                $parentId = 0;
            }
        }

        $data = [
            'objectType'=>$type,
            'objectId'=>$toId,
            'userId'=> Yii::$app->user->id,
            'content'=>$content,
            'createdTime'=>time(),
            'parentId'=>$parentId
        ];

        $res = Yii::$app->db->createCommand()->insert('comment' ,$data)->execute();
        if($res)
        {
            return $this->asJson( ['status'=>1 ] );
        }else{
            return $this->asJson( ['status'=>0 ,'msg'=>'评论失败'] );
        }
    }

    /***
     * 用户中心设置
     * @return string|Response
     */
    public function actionSetting()
    {
        if(Yii::$app->user->isGuest)
        {
            return $this->redirect('site/login');
        }

        $uid = Yii::$app->user->id;
        if(Yii::$app->request->isAjax)
        {
            $data = Yii::$app->request->post('data');

            $exist = Yii::$app->db->createCommand( " select id from user_profile where id=".$uid )->queryScalar();
            $data['id'] = $uid;
            if($exist)
            {
                $result =Yii::$app->db->createCommand()->update('user_profile' ,$data,[ 'id'=>$uid ]  )->execute();
            }else{
                $result =Yii::$app->db->createCommand()->insert('user_profile' ,$data )->execute();
            }

            if($result!==false)
            {
                return $this->asJson(['status'=>1]);
            }else{
                return $this->asJson(['status'=>2 ,'msg'=>'修改失败']);
            }
        }

        $setting = Yii::$app->db->createCommand( 'select * from user_profile where id='.$uid )->queryOne();

        $this->pageTitle = '修改资料';
        return $this->render('setting' , ['setting'=>$setting] );
    }

    /**
     * 设置头像
     * @return string|Response
     * @throws \Exception
     */
    public function actionSetphoto()
    {
        $up = UploadedFile::getInstanceByName('photo');
        if ($up && !$up->getHasError()) {
            $userid = Yii::$app->user->id;
            $filename = $userid . '-' . date('YmdHis') . '.' . $up->getExtension();
            $path = Yii::getAlias('@frontend/web/upload') . '/user/';
            FileHelper::createDirectory($path);
            $up->saveAs($path . $filename);
            $model = User::findOne($userid);
            $oldphoto = $model->userphoto;
            $model->userphoto = $filename;
            if ($model->update()) {
                Yii::$app->session->setFlash('success');
                //删除旧头像
                if (is_file($path . $oldphoto))
                    unlink($path . $oldphoto);
                return $this->goHome();
            } else {
                print_r($model->getErrors());
                exit;
            }
        }
        return $this->render('setphoto', [
            'preview' => Yii::$app->user->identity->userphoto,
        ]);
    }

    /**
     * 修改密码
     * @return string|Response
     */
    public function actionChangepwd()
    {
        $get = Yii::$app->request->get();
		$user_id = Yii::$app->user->id;
		if (isset($get['user_id']) && $get['user_id'] > 0) {
			$user_id = $get['user_id'];
		}
        $model = User::findOne($user_id);
        $model->scenario = 'chgpwd';
		$only_html = false;
		if (isset($get['only_html']) && $get['only_html'] == 1) {
			$only_html = 1;
		}
		$from_user = false;
		if (isset($get['from_user']) && $get['from_user'] == 1) {
			$from_user = 1;
		}
		$page_size = 0;
		if (isset($get['page_size']) && $get['page_size'] >= 1) {
			$page_size = $get['page_size'];
		}
		$page_size = $page_size + 1;
        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success');
            }
            else {
                Yii::$app->session->setFlash('fail');
            }
			if ($from_user == 1) {
				return $this->redirect('index?page='.$page_size);
			}
            return $this->goHome();
        }
		if ($only_html == 1) {
            return $this->renderPartial('changepwd', [
                'model' => $model,
			    'only_html'=>$only_html,
             ]);
		}
        return $this->render('changepwd', [
            'model' => $model,
			'only_html'=>$only_html,
        ]);
    }
}
