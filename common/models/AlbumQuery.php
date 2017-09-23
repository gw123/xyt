<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Album]].
 *
 * @see Album
 */
class AlbumQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/


    /**
     * @inheritdoc
     * @return Album[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Album|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}