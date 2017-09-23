<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class Rbac extends Model
{
    public static function getRolesList()
    {
        $sql = "select * from auth_item where type = 1";
        return Yii::$app->db->createCommand($sql)->queryAll();
    }

    public  static function getCurrentUserRole()
    {
        //先从session 中查找
        $role = Yii::$app->session['user']['role'];
        if(!empty($role)) return  $role;

        $roles = Yii::$app->authManager->getRolesByUser( Yii::$app->user->id );

        $role = array_pop($roles);
        return $role->name;

     }

    public function getRoleByUid($uid)
    {
        //先从session 中查找
        $role = Yii::$app->session['user']['role'];
         if(!empty($role)) return  $role;
        //
        $sql = "select item_name from auth_assignment where user_id = :uid limit 1";
        return Yii::$app->db->createCommand($sql, [':uid' => $uid])->queryScalar();
    }

    public static function  delateRoleByName($roleName)
    {
          $sql = "delete from  auth_item  where name=:name";
          return Yii::$app->db->createCommand($sql,[':name'=>$roleName])->execute();
    }
}
