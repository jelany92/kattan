<?php

namespace common\models\query;

use common\models\auth\AuthItem;

/**
 * This is the ActiveQuery class for [[Vertrage]].
 *
 * @see Vertrage
 */
class UserModelQuery extends \yii\db\ActiveQuery
{
    /**
     * get all users with given role
     *
     * @note uses method AdminUser->getItemNames (here specified as relationname 'itemNames' in joinWith')
     *
     * @param $role
     *
     * @return AdminUserQuery
     */
    public function _role($role)
    {
        return $this->innerJoinWith('itemNames')->andWhere([
                                                               'type' => AuthItem::TYPE_ROLE,
                                                               'name' => $role,
                                                           ]);
    }

}