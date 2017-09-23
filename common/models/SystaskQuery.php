<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Systask]].
 *
 * @see Systask
 */
class SystaskQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Systask[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Systask|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
