<?php
namespace common\components;

use Yii;

class StringHelper extends \yii\helpers\StringHelper
{
    public static function makeGermanEnumeration(array $items) : string
    {
        $outputString = '';
        for($i = 0; $i < count($items); $i++)
        {
            $outputString .= $items[$i];
            if($i < count($items) - 2)
            {
                $outputString .= ', ';
            }
            elseif ($i == count($items) - 2)
            {
                $outputString .= Yii::t('app', ' und ');
            }
        }
        return $outputString;
    }
}