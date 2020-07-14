<?php

namespace common\models\queries;

use common\models\AdminUser;

/**
 * This is the ActiveQuery class for [[\common\models\AdminUserLoginLog]].
 *
 * @see \common\models\AdminUserLoginLog
 */
class AdminUserLoginLogQuery extends \yii\db\ActiveQuery
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

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog|array|null
     */
    public function user(AdminUser $user)
    {
        return parent::andWhere(['user_id' => $user->id]);
    }
}
