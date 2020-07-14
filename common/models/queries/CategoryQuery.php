<?php

namespace common\models\queries;


use common\models\Category;
use common\models\CategoryCompanyType;
use common\models\CompanyType;
use yii\db\Expression;

/**
 * This is the ActiveQuery class for [[\common\models\Component]].
 *
 * @see \common\models\AdminUserLoginLog
 */
class CategoryQuery extends \yii\db\ActiveQuery
{

    /**
     * @param CompanyType $companyType
     *
     * @return \yii\db\ActiveQuery
     */
    public function companyType(CompanyType $companyType)
    {
        return parent::innerJoin(CategoryCompanyType::tableName(), [
            'and',
            new Expression(CategoryCompanyType::tableName() . '.category_id = ' . Category::tableName() . '.id'),
            new Expression(CategoryCompanyType::tableName() . '.company_type_id = '. $companyType->id)
        ]);

    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function active()
    {
        return parent::andWhere(['status' => 1]);
    }
}
