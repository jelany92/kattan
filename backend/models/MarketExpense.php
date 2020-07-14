<?php

namespace backend\models;

use app\models\query\MarketExpensesQuery;
use common\components\ChangeFormat;
use common\models\traits\TimestampBehaviorTrait;
use common\models\UserModel;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * This is the model class for table "market_expense".
 *
 * @property int         $id
 * @property float       $expense
 * @property string      $reason
 * @property string      $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class MarketExpense extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    public $from;
    public $to;

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
            [['reason'], 'trim'],
            [['expense', 'reason', 'selected_date'], 'required'],
            [['expense'], 'validateNumber'],
            [['selected_date', 'created_at', 'updated_at','from', 'to'], 'safe'],
            [['reason'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],
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
            'from'          => Yii::t('app', 'From Date'),
            'to'            => Yii::t('app', 'To Date'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateNumber(string $attribute) : void
    {
        ChangeFormat::validateNumber($this, $attribute);
    }

    /**
     * @return array|bool
     */
    public static function sumResultMarketExpense()
    {
        return (new Query())->select(['result' => 'SUM(e.expense)'])->from(['e' => 'market_expense'])->andWhere(['company_id' => Yii::$app->user->id])->one();
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::class, ['id' => 'company_id']);
    }

    /**
     * @return MarketExpensesQuery|ActiveQuery
     */
    public static function find(): ActiveQuery
    {
        return new MarketExpensesQuery(get_called_class());
    }
}
