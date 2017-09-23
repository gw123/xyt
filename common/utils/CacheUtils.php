<?php
namespace common\utils;

use Yii;

class CacheUtils {

    public static function redis(){

		return Yii::$app->redis;
	}



}
		
?>
