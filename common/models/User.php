<?php
namespace common\models;

use common\utils\PasswordEncoder;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string  $salt
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 1;
    const STATUS_ACTIVE = 0;

    public static function getDb()
    {
        //return Yii::$app->dbEdu;
        return parent::getDb(); // TODO: Change the autogenerated stub
    }


    /**
     * @return int
     */
    public function getCreatedAt()
    {
        return $this->createdTime;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public  function  beforeSave($insert)
    {
       // return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [ ['email','password','nickname','auth_key','password_hash','password_reset_token' ],'string'],
            ['locked', 'default', 'value' => self::STATUS_ACTIVE],
            ['locked', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            [['password_repeat'],'required','on'=>['create','chgpwd']],
        ];
    }

    public  function scenarios()
    {
        $scenarios =  parent::scenarios(); // TODO: Change the autogenerated stub
        $scenarios['create'] = ['email','nickname','auth_key','password_hash','password_reset_token' ];
        $scenarios['update'] = ['id','email','nickname','auth_key','password_hash','password_reset_token' ];
        return $scenarios;
    }

    public  function  getUsername()
    {
        return $this->nickname;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        $res= static::findOne(['id' => $id, 'locked' => self::STATUS_ACTIVE]);
        return $res;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        $res = static::findOne(['nickname' => $username, 'locked' => 0]);
        //exit();
        return $res;
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'locked' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        $passwodEncoder = new PasswordEncoder();
        $fakepwd =  $passwodEncoder->encodePassword($password , $this->salt);
        return $fakepwd == $this->password;
        //return Yii::$app->security->validatePassword($password, $this->salt);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $passwodEncoder = new PasswordEncoder();
        $this->salt =  md5(time());
        $this->password = $passwodEncoder->encodePassword($password ,$this->salt);
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }


    /***
     * 缓存用户信息   内存  cache 双层缓存
     * @return array|mixed
     */
    public  static function   getUserMap()
    {
        if(self::$_users)
            return self::$_users;

        $user =Yii::$app->cache->get('user_map');
        if(empty($users))
        {
            $users = [];
            $usersT = self::find()->select("id , nickname")->asArray()->all();
            foreach ($usersT as $val)
            {
                $users[$val['id']] = $val['nickname'];
            }
            Yii::$app->cache->set('user_map' , $users , 3600);
        }
        self::$_users = $user;
        return  $users;
    }

    //脚本运行内存缓存
    public  static  $_users = [];

    /***
     *获取用户的昵称
     * @param $uid
     * @return string
     */
    public static  function getNickNameById($uid)
    {
        if( !intval($uid) )  return '非法';
        $userMap = self::getUserMap();
        //var_dump($userMap); exit();
        return isset($userMap[$uid]) ? $userMap[$uid] : '--';
    }

    public static function collect($uid , $type , $cid)
    {
        if(empty($uid)||empty($type)||empty($cid))
        {
            return false;
        }
        $uid =intval($uid) ? intval($uid) : 0;
        $cid =intval($cid) ? intval($cid)  : 0;
        $type = strval($type) ? strval($type):'';

        $data = [
            'uid' => $uid,
            'type'=>$type,
            'cid' =>$cid
        ];
        $res = Yii::$app->db->createCommand()->insert('user_collection' , $data)->execute();
        return $res;
    }

    public static function cancelCollect($uid ,$type,$cid)
    {
        if(empty($uid)||empty($type)||empty($cid))
        {
            return false;
        }
        $uid =intval($uid) ? intval($uid) : 0;
        $cid =intval($cid) ? intval($cid)  : 0;
        $type = strval($type) ? strval($type):'';
        $data = [
            'uid' => $uid,
            'type'=>$type,
            'cid' =>$cid
        ];
       return Yii::$app->db->createCommand()->delete('user_collection',$data)->execute();
    }

    /***
     * 判断用户是否收藏了一个资源
     * @param $uid
     * @param $type
     * @param $cid
     */
    public static  function  isCollect($uid , $type , $cid)
    {
        if(empty($uid)||empty($type)||empty($cid))
        {
            return false;
        }
        $uid =intval($uid) ? intval($uid) : 0;
        $cid =intval($cid) ? intval($cid)  : 0;
        $type = strval($type) ? strval($type):'';

        $sql = "select id from user_collection where uid={$uid}  and type ='{$type}' and cid={$cid} ";

        return Yii::$app->db->createCommand($sql)->queryScalar()? true : false;
    }

}
