<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%wp_question_chapter}}".
 *
 * @property integer $id
 * @property integer $pid
 * @property integer $status
 * @property string $name
 * @property integer $lft
 * @property integer $rgt
 * @property integer $root
 */
class Constant
{

    public function  getSubject()
    {
        $subject = array( 1001=>'高数',1002=>'英语',1003=>'物理');
        return $subject;
    }

    public  function getChapter(){
        $chapter = array( 2001=>'');
    }

    public static $Q_templates  =  array('1'=>'choice','2'=>'fill','3'=>'answer','4'=>'mutil');
    public static $Q_types      =  array('1'=>'选择题','2'=>'填空题','3'=>'问答题');
    public static $Q_difficulty =  array('1'=>'困难','2'=>'一般','3'=>'简单');
    public static $Q_importance =  array ('1'=>'必考','2'=>'备考','3'=>'掌握','4'=>'了解');

    public static $CaiJiStatus =  array ('0'=>'采集正确','1'=>'url异常','3'=>'未知错误','10'=>'发布成功');
}
