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
                $sumResult[] = (new Query())->select(['total' => 'SUM(' . $total . ')'])->from([$from])->andWhere(['selected_date' => $date->format("Y-m-d")])->one();
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
        $lastDay = date("Y-m-t", strtotime(date($year . '-' . $month . "-t")));;

        $sumResultIncomingRevenue = (new Query())->select([
            'total' => 'tn.' . $columnName,
            'date'  => 'tn.selected_date',
            $select,
        ])->from(['tn' => $tableName])->andWhere([
            'between',
            'tn.selected_date',
            $year . '-' . $month . '-01',
            $lastDay,
        ])->all();

        return $sumResultIncomingRevenue;
    }

    /**
     * @param string $where
     * @param string $tableName
     * @param string $rowName
     * @param string $search
     *
     * @return array|bool
     */
    public static function sumsSearchResult(string $tableName, string $rowName, string $where, string $search)
    {
        return (new Query())->select(['result' => 'SUM(tn.' . $rowName . ')'])->from(['tn' => $tableName])->andWhere(['like', $where, $search])->one();
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
        $exporter = new Spreadsheet([
            'dataProvider' => $activeDataProvider,
        ]);
        $exporter->columns = $columnNames;
        return $exporter->send($fileName);
    }
}