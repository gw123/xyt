<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $nickname;
    public $email;
    public $password;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['nickname', 'trim'],
            ['nickname', 'required'],
            ['nickname', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已经被使用'],
            ['nickname', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '该邮箱已经被使用.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->nickname = $this->nickname;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $attr = $user->getAttributes();
        foreach ($attr as $key => $val )
        {
            if(empty($val))  unset($attr[$key]);
        }

        if( \Yii::$app->db->createCommand()->insert('user' ,$attr)->execute())
        {
            $userid = \Yii::$app->db->getLastInsertID();
            $user->id = $userid;
            return $user;
        }

        return  null;
    }
}


