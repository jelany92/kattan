<?php

namespace backend\models;

use app\models\query\IncomingRevenueQuery;
use common\components\ChangeFormat;
use common\models\query\traits\TimestampBehaviorTrait;
use common\models\UserModel;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Expression;
use yii\db\Query;

/**
 * This is the model class for table "incoming_revenue".
 *
 * @property int $id
 * @property double $daily_incoming_revenue
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class IncomingRevenue extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'incoming_revenue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['daily_incoming_revenue', 'selected_date'], 'required'],
            [['id', 'company_id'], 'integer'],
            [['daily_incoming_revenue'], 'validateNumber'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                     => Yii::t('app', 'ID'),
            'daily_incoming_revenue' => Yii::t('app', 'Daily Incoming Revenue'),
            'selected_date'          => Yii::t('app', 'Selected Date'),
            'created_at'             => Yii::t('app', 'Created At'),
            'updated_at'             => Yii::t('app', 'Updated At'),
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
    public static function sumResultIncomingRevenue()
    {
        return (new Query())->select(['result' => 'SUM(ir.daily_incoming_revenue)'])->from(['ir' => 'incoming_revenue'])->andWhere(['company_id' => Yii::$app->user->id])->one();
    }

    /**
     * @param int $year
     * @param string $month
     * @return array
     */
    public static function getDailyDataIncomingRevenue(int $year, string $month)
    {
        $sumResultIncomingRevenue = (new Query())
            ->select(['total_income' => 'ir.daily_incoming_revenue', 'date' => 'ir.selected_date'])
            ->from(['ir' => 'incoming_revenue'])
            ->andWhere(
                ['between', 'ir.selected_date',   $year . '-' . $month . '-01',  $year . '-' . $month . '-30']
            )->all();

        return $sumResultIncomingRevenue;
    }

    /**
     * @param int $year
     * @param string $month
     * @param string $from
     * @return array
     */
    public static function gatMonthlyData(int $year, string $month)
    {
        $sumResultIncomingRevenue = (new Query())
            ->select(['total' => 'daily_incoming_revenue', 'date' => 'selected_date'])
            ->from(['ir' => 'incoming_revenue'])
            ->andWhere(
                ['between', 'selected_date',   $year . '-' . $month . '-01")',  $year . '-' . $month . '-30']
            )->all();

        return $sumResultIncomingRevenue;
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
     * @param string $date
     *
     * @return array
     * @throws \yii\db\Exception
     */
    public static function getDailyInformation(string $date) : array
    {
        $modelIncomingRevenue = IncomingRevenue::find()->select([
                                                                    'type'   => 'IF(id = 0, "", "' . Yii::t('app', 'Incoming Revenue') . '")',
                                                                    'reason' => 'IF(id = 0, "", null)',
                                                                    'result' => 'daily_incoming_revenue',
                                                                ])->andWhere([
                                                                                 'company_id'    => Yii::$app->user->id,
                                                                                 'selected_date' => $date,
                                                                             ]);
        $modelPurchases       = Purchases::find()->select([
                                                              'type'   => 'IF(id = 0, "", "' . Yii::t('app', 'Purchases') . '")',
                                                              'reason' => 'reason',
                                                              'result' => 'purchases',
                                                          ])->andWhere([
                                                                           'company_id'    => Yii::$app->user->id,
                                                                           'selected_date' => $date,
                                                                       ]);
        $modelMarketExpense   = MarketExpense::find()->select([
                                                                  'type'   => 'IF(id = 0, "", "' . Yii::t('app', 'Market Expense') . '")',
                                                                  'reason',
                                                                  'result' => 'expense',
                                                              ])->andWhere([
                                                                               'company_id'    => Yii::$app->user->id,
                                                                               'selected_date' => $date,
                                                                           ]);
        $modelTaxOffice       = TaxOffice::find()->select([
                                                              'type'   => 'IF(id = 0, "", "' . Yii::t('app', 'Tax Office') . '")',
                                                              'reason' => 'IF(id = 0, "", null)',
                                                              'result' => 'income',
                                                          ])->andWhere([
                                                                           'company_id'    => Yii::$app->user->id,
                                                                           'selected_date' => $date,
                                                                       ]);
        return $modelIncomingRevenue->union($modelPurchases)->union($modelMarketExpense)->union($modelTaxOffice)->createCommand()->queryAll();

    }
    /**
     * @return IncomingRevenueQuery|ActiveQuery
     */
    public static function find() : ActiveQuery
    {
        return new IncomingRevenueQuery(get_called_class());
    }
}
