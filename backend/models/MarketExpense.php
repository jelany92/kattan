<?php

namespace backend\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "market_expense".
 *
 * @property int $id
 * @property float $expense
 * @property string $reason
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class MarketExpense extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'market_expense';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expense', 'reason', 'selected_date'], 'required'],
            [['expense'], 'number'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['reason'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'expense'       => Yii::t('app', 'Expense'),
            'reason'        => Yii::t('app', 'Reason'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array|bool
     */
    public static function sumResultMarketExpense()
    {
        return (new Query())->select(['result' => 'SUM(e.expense)'])->from(['e' => 'market_expense'])->one();
    }
}
