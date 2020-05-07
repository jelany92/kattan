<?php

namespace common\components;

use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;

class QueryHelper extends \yii\helpers\StringHelper
{
    /**
     * Statistiken Für ganze Monat
     *
     * @param int    $year
     * @param int    $month
     * @param string $total
     *
     * @return array
     * @throws \yii\web\HttpException
     */
    public static function getMonthData(int $year, int $month, $from, string $total)
    {
        if ($month < 1 || 12 < $month)
        {
            throw new \yii\web\HttpException(404, 'The requested Item could not be found.');
        }

        // erster und letzter Tag im Monat
        $firstDay = new \DateTime($year . '-' . $month . '-01');
        $lastDay  = new \DateTime($firstDay->format('Y-m-t'));
        $dates    = [];

        // Schleife für jeden Tag im Monat
        for ($i = 1; $i <= $lastDay->format('d'); $i++)
        {
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
     * @param        $dates
     * @param string $from
     * @param string $total
     *
     * @return float|int
     * @throws \Exception
     */
    protected static function getDataByDates($dates, string $from, string $total)
    {
        $result = [];
        foreach ($dates AS $date)
        {
            if ($date instanceof \DateTime)
            {
                $sumResult[] = (new Query())->select(['total' => 'SUM(' . $total . ')'])->from([$from])->andWhere(['selected_date' => $date->format("Y-m-d"), 'company_id' => Yii::$app->user->id])->one();
            }
            else
            {
                throw new \Exception('invalid date');
            }
        }
        foreach ($sumResult as $key => $totalResult)
        {
            if ($totalResult['total'] != null)
            {
                $result[] = $totalResult['total'];
            }
        }

        return $result != null ? array_sum($result) : 0;
    }


    /**
     * @param int    $year
     * @param string $month
     * @param string $tableName
     * @param string $columnName
     * @param string $select
     *
     * @return array
     */
    public static function getDailyInfo(int $year, string $month, string $tableName, string $columnName, string $select)
    {
        $date                     = $year . '-' . $month . "-01";
        $lastDay                  = date("Y-m-t", strtotime($date));
        $sumResultIncomingRevenue = (new Query())->select([
            'total' => 'tn.' . $columnName,
            'date'  => 'tn.selected_date',
            $select,
        ])->from(['tn' => $tableName])->andWhere([
            'between',
            'tn.selected_date',
            $year . '-' . $month . '-01',
            $lastDay,
        ])->andWhere(['company_id' => Yii::$app->user->id])->orderBy(['date' => SORT_ASC])->all();

        return $sumResultIncomingRevenue;
    }

    public static function getResult(int $year, string $month)
    {
        $lastDay = date("t", strtotime(date($year . '-' . $month . "-t")));;
        $count = [];
        for ($i = 1; $i <= $lastDay; $i++)
        {
            $date                 = date($year . '-' . $month . '-' . $i, strtotime(date($year . '-' . $month . "d")));
            $dailyIncomingRevenue = (new Query())->select(['count' => 'SUM(daily_incoming_revenue)'])->from('incoming_revenue')->andWhere(['selected_date' => $date])->andWhere(['company_id' => Yii::$app->user->id])->one();
            foreach ($dailyIncomingRevenue as $incomingRevenue)
            {
                $dailyPurchases = (new Query())->select(['count' => 'SUM(purchases)'])->from('purchases')->andWhere(['selected_date' => $date, 'company_id' => Yii::$app->user->id])->one();
                foreach ($dailyPurchases as $purchases)
                {
                    $dailyMarketExpense = (new Query())->select(['count' => 'SUM(expense)'])->from('market_expense')->andWhere(['selected_date' => $date, 'company_id' => Yii::$app->user->id])->one();
                    foreach ($dailyMarketExpense as $marketExpense)
                    {
                        if ($incomingRevenue != null)
                        {
                            if ($purchases != null)
                            {
                                if ($marketExpense != null)
                                {
                                    $count[] = [
                                        $incomingRevenue - $purchases - $marketExpense,
                                        $date,
                                    ];
                                }
                                else
                                {
                                    $count[] = [
                                        $incomingRevenue - $purchases,
                                        $date,
                                    ];
                                }
                            }
                            elseif ($marketExpense != null)
                            {
                                $count[] = [
                                    $incomingRevenue - $marketExpense,
                                    $date,
                                ];
                            }
                            else
                            {
                                $count[] = [
                                    $incomingRevenue,
                                    $date,
                                ];
                            }
                        }
                    }
                }
            }
        }

        return $count;
    }

    public static function sumsSameResult(string $tableName, $result, int $year, int $month)
    {
        $from = $year . '-' . $month . '-01';
        $to   = date("Y-m-t", strtotime($from));
        return (new Query())->select([
            'result' => 'SUM(tn.' . $result . ')',
            'reason',
        ])->from(['tn' => $tableName])->andWhere([
            'Between',
            'selected_date',
            $from,
            $to,
        ])->andWhere(['company_id' => Yii::$app->user->id])->groupBy('reason')->all();
    }

    /**
     * @param string      $tableName
     * @param string      $rowName
     * @param string      $where
     * @param string      $search
     * @param null|string $from
     * @param null|string $to
     *
     * @return array|bool
     */
    public static function sumsSearchResult(string $tableName, string $rowName, string $where, string $search, ? string $from, ? string $to)
    {
        if ($from != null)
        {
            if ($to != null)
            {
                return (new Query())->select(['result' => 'SUM(tn.' . $rowName . ')'])->from(['tn' => $tableName])->andWhere([
                    'like',
                    $where,
                    $search,
                ])->andWhere([
                    'Between',
                    'selected_date',
                    $from,
                    $to,
                ])->one();
            }
            return (new Query())->select(['result' => 'SUM(tn.' . $rowName . ')'])->from(['tn' => $tableName])->andWhere([
                'like',
                $where,
                $search,
            ])->andWhere([
                'Between',
                'selected_date',
                $from,
                'CURRENT_TIMESTAMP',
            ])->andWhere(['company_id' => Yii::$app->user->id])->one();
        }
        return (new Query())->select(['result' => 'SUM(tn.' . $rowName . ')'])->from(['tn' => $tableName])->andWhere([
            'like',
            $where,
            $search,
        ])->andWhere(['company_id' => Yii::$app->user->id])->one();

    }

    /**
     * @param ActiveDataProvider $activeDataProvider
     * @param array              $columnNames
     * @param string             $fileName
     *
     * @return Response
     */
    public static function fileExport(ActiveDataProvider $activeDataProvider, array $columnNames, string $fileName): Response
    {
        $exporter          = new Spreadsheet([
            'dataProvider' => $activeDataProvider,
        ]);
        $exporter->columns = $columnNames;
        return $exporter->send($fileName);
    }
}