<?php

namespace backend\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tax_office".
 *
 * @property int $id
 * @property double $income
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TaxOffice extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tax_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['income', 'selected_date'], 'required'],
            [['income'], 'double'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'income'        => Yii::t('app', 'Income'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array|bool
     */
    public static function sumResultTaxOffice()
    {
        return (new Query())->select(['result' => 'SUM(e.income)'])->from(['e' => 'tax_office'])->one();
    }
}
