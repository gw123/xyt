<?php
namespace frontend\listener;

use yii\base\Component;

class  BaseListener extends Component{

    const  UPDATE= 0x1;
    const  DELETE= 0x2;
    const  CREATE =0x3;
    const  VIEW   =0x4;
    const  COMMENT = 0x5;
    const  COLLECT = 0x6;

    public static  function onUpdate($event)
    {

    }

    public static function onDelete($event)
    {

    }

    public static function onCreate($event)
    {

    }

    public static function onView($event)
    {

    }

}
