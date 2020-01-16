<?php

namespace app\models\query;

use app\models\query\traits\UserTrait;
use Codeception\Step\Condition;
use yii\db\conditions\BetweenColumnsCondition;

/**
 * This is the ActiveQuery class for [[Vertrage]].
 *
 * @see Vertrage
 */
class IncomingRevenueQuery extends \yii\db\ActiveQuery
{

    /**
     * wenn vertrag ist
     * @param \DateTime $date
     * @return $this
     */
    public function forDate(\DateTime $date)
    {
        return $this->andWhere(['selected_date' => $date->format('Y-m-d')]);
    }

}