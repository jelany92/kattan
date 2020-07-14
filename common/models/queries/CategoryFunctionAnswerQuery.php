<?php

namespace common\models\queries;

use common\models\CategoryFunctionAnswer;

/**
 * This is the ActiveQuery class for [[\common\models\Component]].
 *
 * @see \common\models\AdminUserLoginLog
 */
class CategoryFunctionAnswerQuery extends \yii\db\ActiveQuery
{
    /**
     * @param $baseDataId
     * @param $functionId
     *
     * @return bool|int|mixed
     */
    public static function isTestCriteriaChecked($baseDataId, $functionId)
    {
        $CategoryFunctionAnswer = CategoryFunctionAnswer::find()->andWhere(['base_data_id' => $baseDataId,'function_id' => $functionId])->one();
        if ($CategoryFunctionAnswer instanceof CategoryFunctionAnswer)
        {
            return $CategoryFunctionAnswer->test_criteria;
        }
        else
        {
            return false;
        }
    }

    /**
     * @param $baseDataId
     * @param $functionId
     *
     * @return bool|int|mixed
     */
    public static function isExplainChecked($baseDataId, $functionId)
    {
        $CategoryFunctionAnswer = CategoryFunctionAnswer::find()->andWhere(['base_data_id' => $baseDataId,'function_id' => $functionId])->one();
        if ($CategoryFunctionAnswer instanceof CategoryFunctionAnswer)
        {
            return $CategoryFunctionAnswer->explain;
        }
        else
        {
            return false;
        }
    }
}
