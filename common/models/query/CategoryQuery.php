<?php

namespace common\models\query;

use app\models\query\traits\UserTrait;
use Codeception\Step\Condition;
use yii\db\conditions\BetweenColumnsCondition;

/**
 * This is the ActiveQuery class for [[Vertrage]].
 *
 * @see Vertrage
 */
class CategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * @param int $userId
     *
     * @return CategoryQuery
     */
    public function userId(int $userId) : CategoryQuery
    {
        return $this->andWhere(['company_id' => $userId]);
    }

}