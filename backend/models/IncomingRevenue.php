<?php

namespace backend\models;

use app\models\query\IncomingRevenueQuery;
use common\models\query\traits\TimestampBehaviorTrait;
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
            [['daily_incoming_revenue'], 'double'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
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
     * @return array|bool
     */
    public static function sumResultIncomingRevenue()
    {
        return (new Query())->select(['result' => 'SUM(ir.daily_incoming_revenue)'])->from(['ir' => 'incoming_revenue'])->one();
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
     * Statistiken Für ganze Monat
     *
     * @param int $year
     * @param int $month
     * @param string $total
     * @return array
     * @throws \yii\web\HttpException
     */
    public static function getMonthData(int $year, int $month, $from, string $total)
    {
        if ($month < 1 || 12 < $month) {
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
        }

        // erster und letzter Tag im Monat
        $firstDay = new \DateTime($year . '-' . $month . '-01');
        $lastDay = new \DateTime($firstDay->format('Y-m-t'));
        $dates = array();

        // Schleife für jeden Tag im Monat
        for ($i = 1; $i <= $lastDay->format('d'); $i++) {
            $dates[] = clone $firstDay;
            $firstDay->modify('+1 day');
        }
        return self::getDataByDates($dates, $from, $total);

        throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
    }

    /**
     * Statistiken Für Year
     *
     * @param int $year
     * @param string $total
     * @param string $from
     * @return array
     * @throws \Exception
     */
    public static function getYearData(int $year, string $from, string $total)
    {
        if ($year < 2019 || 2030 < $year) {
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
        }
        $dates = array();
        for ($m = 1; $m <= 12; $m++) {
            $firstDayInMonth = new \DateTime($year . '-' . $m . '-01');
            $lastDayInMonth = new \DateTime($firstDayInMonth->format('Y-m-t'));
            for ($i = 1; $i <= $lastDayInMonth->format('d'); $i++) {
                $dates[] = clone $firstDayInMonth;
                $firstDayInMonth->modify('+1 day');
            }
        }
        return self::getDataByDates($dates, $from, $total);
    }

    /**
     * Statistic alle Date von Dates
     *
     * @param $dates
     * @param string $from
     * @param string $total
     * @return float|int
     * @throws \Exception
     */
    protected static function getDataByDates($dates, string $from, string $total)
    {
        $result = [];
        foreach ($dates AS $date) {
            if ($date instanceof \DateTime) {
                $sumResultIncomingRevenue[] = (new Query())
                    ->select(['total' => 'SUM('. $total .')'])
                    ->from([$from])
                    ->andWhere(['selected_date' => $date->format("Y-m-d")])
                    ->one();
            }
            else
            {
                throw new \Exception('invalid date');
            }
        }
        foreach ($sumResultIncomingRevenue as $key => $totalResult)
        {
            if ($totalResult['total'] != null)
            {
                $result[] = $totalResult['total'];
            }
        }

        return $result != null ? array_sum($result) : 0;
    }

    /**
     * @return IncomingRevenueQuery|ActiveQuery
     */
    public static function find() : ActiveQuery
    {
        return new IncomingRevenueQuery(get_called_class());
    }
}
