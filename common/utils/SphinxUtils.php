<?php
namespace common\utils;
use yii;

class SphinxUtils {

    public static function filterColumn($columns,$attributes,$isMva = false) {
        $destColumns = [];
        foreach($columns as $name) {
            $value = $attributes[$name];
            if($isMva) {
                if($value) {
                    $destColumns[$name] = explode(",",$value);
                }
            }else {
                if (!is_string($value)) {
                    $value = strval($value);
                }
                $destColumns[$name] = $value;
            }
        }
        return $destColumns;
    }

    public static function updateIndex($rtindex,$columns) {
        $params = [];
        $sql = \Yii::$app->sphinx->getQueryBuilder()
            ->replace(
                $rtindex,
                $columns,
                $params
        );
        return \Yii::$app->sphinx->createCommand($sql, $params)->execute();
    }
}
 

?>
