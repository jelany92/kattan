<?php

namespace backend\models;

use app\models\query\PurchasesQuery;
use common\components\ChangeFormat;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\Query;

/**
 * This is the model class for table "purchases".
 *
 * @property int $id
 * @property int $company_id
 * @property double $purchases
 * @property string $reason
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Purchases extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    public $from;
    public $to;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reason'], 'trim'],
            [['id', 'company_id'], 'integer'],
            [['purchases', 'selected_date', 'reason'], 'required'],
            [['purchases'], 'validateNumber'],
            [['reason', 'selected_date', 'created_at', 'updated_at','from', 'to'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'purchases'     => Yii::t('app', 'Purchases'),
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
    public static function sumResultPurchases()
    {
        return (new Query())->select(['result' => 'SUM(ir.purchases)'])->from(['ir' => 'purchases'])->andWhere(['company_id' => Yii::$app->user->id])->one();
    }


    /**
     * @param int $year
     * @param string $month
     * @return array
     */
    public static function getDailyPurchases(int $year, string $month)
    {
        $sumResultIncomingRevenue = (new Query())
            ->select(['total_output' => 'p.Purchases', 'date' => 'p.selected_date'])
            ->from(['p' => 'purchases'])
            ->andWhere(
                ['between', 'p.selected_date',   $year . '-' . $month . '-01',  $year . '-' . $month . '-30']
            )->all();

        return $sumResultIncomingRevenue;
    }

    /**
     * sammelt date und zeit in einem spalte
     * es wird benutzt in actionCreate
     * @return mixed
     *
     * @param \DateTime $date
     * @param string    $time
     */
    public function dateFormat(\DateTime $date, $time)              // sammelt date und zeit in einem spalte
    {
        $timeDT = \DateTime::createFromFormat('H:i', $time);
        $date->setTime($timeDT->format('G'), $timeDT->format('i'));
        return $date;
    }

    /**
     * @return PurchasesQuery|ActiveQuery
     */
    public static function find() : ActiveQuery
    {
        return new PurchasesQuery(get_called_class());
    }
}
