<?php

namespace common\models\auth\queries;

/**
 * This is the ActiveQuery class for [[\common\models\AdminUserLog]].
 *
 * @see \common\models\AdminUserLog
 */
class AuthItemChildQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }



}
