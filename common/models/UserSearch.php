<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'point', 'coin', 'emailVerified', 'setup', 'promoted', 'promotedSeq', 'promotedTime', 'locked', 'lockDeadline', 'consecutivePasswordErrorTimes', 'lastPasswordFailTime', 'loginTime', 'approvalTime', 'newMessageNum', 'newNotificationNum', 'createdTime', 'updatedTime', 'orgId'], 'integer'],
            [['email', 'verifiedMobile', 'password', 'salt', 'payPassword', 'payPasswordSalt', 'locale', 'uri', 'nickname', 'title', 'tags', 'type', 'smallAvatar', 'mediumAvatar', 'largeAvatar', 'roles', 'loginIp', 'loginSessionId', 'approvalStatus', 'createdIp', 'inviteCode', 'orgCode', 'registeredWay', 'auth_key', 'password_hash', 'password_reset_token'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'point' => $this->point,
            'coin' => $this->coin,
            'emailVerified' => $this->emailVerified,
            'setup' => $this->setup,
            'promoted' => $this->promoted,
            'promotedSeq' => $this->promotedSeq,
            'promotedTime' => $this->promotedTime,
            'locked' => $this->locked,
            'lockDeadline' => $this->lockDeadline,
            'consecutivePasswordErrorTimes' => $this->consecutivePasswordErrorTimes,
            'lastPasswordFailTime' => $this->lastPasswordFailTime,
            'loginTime' => $this->loginTime,
            'approvalTime' => $this->approvalTime,
            'newMessageNum' => $this->newMessageNum,
            'newNotificationNum' => $this->newNotificationNum,
            'createdTime' => $this->createdTime,
            'updatedTime' => $this->updatedTime,
            'orgId' => $this->orgId,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'verifiedMobile', $this->verifiedMobile])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'salt', $this->salt])
            ->andFilterWhere(['like', 'payPassword', $this->payPassword])
            ->andFilterWhere(['like', 'payPasswordSalt', $this->payPasswordSalt])
            ->andFilterWhere(['like', 'locale', $this->locale])
            ->andFilterWhere(['like', 'uri', $this->uri])
            ->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'tags', $this->tags])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'smallAvatar', $this->smallAvatar])
            ->andFilterWhere(['like', 'mediumAvatar', $this->mediumAvatar])
            ->andFilterWhere(['like', 'largeAvatar', $this->largeAvatar])
            ->andFilterWhere(['like', 'roles', $this->roles])
            ->andFilterWhere(['like', 'loginIp', $this->loginIp])
            ->andFilterWhere(['like', 'loginSessionId', $this->loginSessionId])
            ->andFilterWhere(['like', 'approvalStatus', $this->approvalStatus])
            ->andFilterWhere(['like', 'createdIp', $this->createdIp])
            ->andFilterWhere(['like', 'inviteCode', $this->inviteCode])
            ->andFilterWhere(['like', 'orgCode', $this->orgCode])
            ->andFilterWhere(['like', 'registeredWay', $this->registeredWay])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token]);

        return $dataProvider;
    }

    /***
     * @param $type
     * @param $toid
     * @param string $uid
     * @return array|bool
     */
    public static function getComments($type ,$toid , $uid='')
    {
        $type = strval($type);
        $toid = intval($toid);
        $uid =  intval($uid);
        if(empty($type)||empty($toid))
        {
            return false;
        }

        if(!$uid)
        {
            $where = " where objectId={$toid} and objectType='{$type}' ";
        }else{
            $where = " where objectId={$toid} and objectType='{$type}' and userId=$uid ";
        }

        $sql = "select user.nickname,user.smallAvatar as avatar ,comment.* from comment inner join user on  comment.userId = user.id".$where." limit 50";
        $rows=  Yii::$app->db->createCommand($sql)->queryAll();
        if(!empty($rows))
        foreach ($rows as &$row)
        {
            $row['createdTime'] = date("Y-m-d h:i:s" , $row['createdTime']);
            if(empty($row['avatar']))
                $row['avatar'] = Yii::$app->params['defaultAvatar'];
        }
        return $rows;
    }

    /*** 获取用户收藏
     * @param $uid
     * @param $type
     * @param int $page
     * @param int $pageSize
     * @return array|bool
     */
    public static function getUserCollect($uid , $type ,$page =1,$pageSize=10)
    {
        if(empty($uid)||empty($type)||!intval($page)||!intval($pageSize))
        {
            return false;
        }
        $uid =intval($uid) ? intval($uid) : 0;
        $filter = ['book' ,'article','video','material','user'];
        if(!in_array($type,$filter))
        {
            return ['total'=>0 , 'rows'=>[]];
        }

        $pageSize = intval($pageSize);
        $page=intval($page);
        $limit = " limit ".(($page-1)*$pageSize).",".$pageSize;

        $sql = "select count(*) as total from user_collection where uid={$uid}  and type ='{$type}' ";
        $total =  Yii::$app->db->createCommand($sql)->queryScalar();
        $rows =[];
        switch ($type)
        {
            case 'article':
                $sql = "select o.id ,o.title from user_collection as c inner join article as o on c.cid=o.id   where c.uid={$uid}  and c.type ='{$type}' ".$limit;
                break;
            case 'book':
                $sql = "select o.id ,o.title from user_collection as c inner join book as o on c.cid=o.id   where c.uid={$uid}  and c.type ='{$type}' ".$limit;
                break;
            case  'video':
                $sql = "select o.id ,o.title from user_collection as c inner join video as o on c.cid=o.id   where c.uid={$uid}  and c.type ='{$type}' ".$limit;
                break;
            case 'material':
                $sql = "select o.id ,o.title from user_collection as c inner join material as o on c.cid=o.id   where c.uid={$uid}  and c.type ='{$type}' ".$limit;
                break;
        }
       // echo $sql;
        $rows =  Yii::$app->db->createCommand($sql)->queryAll();
        return ['total'=>$total , 'rows'=>$rows];
    }
}
