<?php
namespace common\models;
use Yii;
use \creocoder\nestedsets\NestedSetsBehavior;

class Tree   extends \kartik\tree\models\Tree
{

    public  static  function  behaviors()
    {

    }

    /**
    * @inheritdoc
    */
    public static function tableName()
    {
      return 'wp_tree';
    }


}
