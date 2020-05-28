<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[Vertrage]].
 *
 * @see Vertrage
 */
class MainCategoryQuery extends \yii\db\ActiveQuery
{
    /**
     * @param int $userId
     *
     * @return MainCategoryQuery
     */
    public function userId(int $userId) : MainCategoryQuery
    {
        return $this->andWhere(['company_id' => $userId]);
    }

}