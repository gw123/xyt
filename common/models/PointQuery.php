<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Point]].
 *
 * @see Point
 */
class PointQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Point[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Point|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
