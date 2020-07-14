<?php

namespace common\models\auth\queries;

use common\models\auth\AuthItem;
use common\models\auth\AuthItemChild;

/**
 * This is the ActiveQuery class for [[\common\models\AdminUserLog]].
 *
 * @see \common\models\AdminUserLog
 */
class AuthItemQuery extends \yii\db\ActiveQuery
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
    public function role()
    {
        return parent::andWhere(['type' => AuthItem::TYPE_ROLE]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog|array|null
     */
    public function task()
    {
        return parent::andWhere(['type' => AuthItem::TYPE_TASK]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog|array|null
     */
    public function permission()
    {
        return parent::andWhere(['type' => AuthItem::TYPE_PERMISSION]);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\AdminUserLog|array|null
     */
    public function child($name)
    {
        return parent::alias('t')
                     ->innerJoin(AuthItemChild::tableName() . ' AS c', 't.name = c.child')
                     ->andWhere(['parent' => $name]);
    }

    /**
     * returns a list of parents AuthItem objects related to the given child object
     * @return \common\models\AdminUserLog|array|null
     */
    public function parent($name)
    {
        return parent::alias('t')
                     ->innerJoin(AuthItemChild::tableName() . ' AS c', 't.name = c.parent')
                     ->andWhere(['child' => $name]);
    }
}
