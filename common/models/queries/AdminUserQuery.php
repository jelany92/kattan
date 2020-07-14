<?php

namespace common\models\queries;
use common\models\auth\AuthItem;

/**
 * This is the ActiveQuery class for [[\common\models\AdminUser]].
 *
 * @see \common\models\AdminUser
 */
class AdminUserQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * Selects all entries that are automatically to activate
     * @return \yii\db\ActiveQuery
     */
    public function toActivate()
    {
        return parent::andWhere(['<=', 'active_from', date('Y-m-d H:i:s')]) // active_from <= date('Y-m-d H:i:s')
                     ->andWhere(['OR', ['active_until' => null], ['>=', 'active_until', date('Y-m-d H:i:s')]]) // active_until IS NULL OR date('Y-m-d H:i:s') <= active_until
                     ->andWhere(['password' => null])
                     ->andWhere(['password_reset_token' => null]);
    }

    /**
     * Selects all active entries
     * @return \yii\db\ActiveQuery
     */
    public function active()
    {
        return parent::andWhere(['<=', 'active_from', date('Y-m-d H:i:s')]) // active_from <= date('Y-m-d H:i:s')
                     ->andWhere(['OR', ['active_until' => null], ['>=', 'active_until', date('Y-m-d H:i:s')]]) // active_until IS NULL OR date('Y-m-d H:i:s') <= active_until
                     ->andWhere(['not', ['password' => null]]);
    }

    /**
     * get all users with given role
     * @note uses method AdminUser->getItemNames (here specified as relationname 'itemNames' in joinWith')
     * @param $role
     *
     * @return \yii\db\ActiveQuery
     */
    public function role($role){
        return parent::innerJoinWith('itemNames')->andWhere(['type'=> AuthItem::TYPE_ROLE, 'name' => $role]);
    }
}
