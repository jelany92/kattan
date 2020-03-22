<?php

namespace common\components;

use Yii;
use yii\db\ActiveRecord;

class ChangeFormat
{
    /**
     * @param string $attribute
     *
     * @return mixed
     */
    public static function changeNumberFormatFromArabicToEnglish(string $attribute)
    {
        // ١ ٢ ٣ ٤ ٥ ٦ ٧ ٨ ٩ ٠
        return str_replace(['٠','١','٢','٣','٤','٥','٦','٧','٨','٩'], ['0','1','2','3','4','5','6','7','8','9'], $attribute);
    }

    /**
     * @param string       $attribute
     * @param ActiveRecord $model
     *
     * @return int|string
     */
    public static function validateNumber(ActiveRecord $model, string $attribute)
    {
        if (!is_numeric($model->$attribute))
        {
            $dailyIncomingRevenue = ChangeFormat::changeNumberFormatFromArabicToEnglish($model->$attribute);
            if (is_numeric($dailyIncomingRevenue))
            {
                return $model->$attribute = $dailyIncomingRevenue;
            }
            else
            {
                $model->addError($attribute, Yii::t('app', '{0} must be a number', [$model->attributeLabels()[$attribute]]));
            }
        }
    }
}