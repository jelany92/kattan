<?php

namespace common\models\queries;

use common\models\BaseData;
use common\models\CompanyType;
use common\models\Component;
use common\models\FunctionCompanyType;
use common\models\FunctionCondition;
use common\models\FunctionRestrictToProject;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\common\models\Component]].
 *
 * @see \common\models\AdminUserLoginLog
 */
class ComponentQuery extends \yii\db\ActiveQuery
{
    /**
     * @param BaseData $baseData
     *
     * @return \yii\db\ActiveQuery
     */
    public function project(BaseData $baseData)
    {
        return parent::leftJoin(FunctionRestrictToProject::tableName(),[FunctionRestrictToProject::tableName() . '.function_id' => new Expression(Component::tableName() . '.id')])->andWhere([
            'OR',
            [FunctionRestrictToProject::tableName() . '.base_data_id' => $baseData->id],
            [FunctionRestrictToProject::tableName() . '.base_data_id' => null],
        ]);
    }

    /**
     * @param CompanyType $companyType
     *
     * @return \yii\db\ActiveQuery
     */
    public function companyType(CompanyType $companyType)
    {
        return parent::innerJoin(FunctionCompanyType::tableName(), [
            FunctionCompanyType::tableName() . '.function_id' => new Expression(Component::tableName() . '.id'),
            FunctionCompanyType::tableName() . '.company_type_id' => $companyType->id
        ]);
    }

    /**
     * @param BaseData $baseData
     *
     * @return \yii\db\ActiveQuery
     */
    public function conditions(BaseData $baseData)
    {
        $conditionIds = [];
        if (0 < count($baseData->conditions))
        {
            foreach ($baseData->conditions AS $condition)
            {
                $conditionIds[] = $condition->id;
            }
        }
        return parent::leftJoin(FunctionCondition::tableName(), [FunctionCondition::tableName() . '.function_id' => new Expression(Component::tableName() . '.id')])
                     ->andWhere([
            'OR',
            ['in', FunctionCondition::tableName() . '.condition_id', $conditionIds],
            [FunctionCondition::tableName() . '.condition_id' => null],
        ]);
    }
}
