<?php

namespace backend\models\query;

/**
 * This is the ActiveQuery class for [[\backend\models\ArticleInStored]].
 *
 * @see \backend\models\ArticleInStored
 */
class ArticleInStoredQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \backend\models\ArticleInStored[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\ArticleInStored|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
