<?php

namespace backend\controllers;

use backend\models\MarketExpense;
use backend\models\Purchases;
use common\components\QueryHelper;
use yii\data\ArrayDataProvider;
use yii\web\Controller;

class StatisticController extends Controller
{
    public function actionMonthIncome($year, $month)
    {
        $dailyInfo              = QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id');
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
             'allModels'  => $dailyInfo,
             'pagination' => false,
         ]);

        return $this->render('month-details/income', [
            'month'                => $month,
            'year'                 => $year,
            'modelIncomingRevenue' => $dataProviderIncomingRevenue,
            'queryDailyInfo'       => $dailyInfo,
        ]);
    }

    public function actionMonthPurchases($year, $month)
    {
        $dataProviderPurchases = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);


        return $this->render('month-details/purchases', [
            'month'          => $month,
            'year'           => $year,
            'modelPurchases' => $dataProviderPurchases,
        ]);
    }

    public function actionMonthPurchasesGroup($year, $month)
    {
        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month, 'reason'),
             'pagination' => false,
         ]);
        return $this->render('month-details/purchases-group', [
            'month'                      => $month,
            'year'                       => $year,
            'dataProviderPurchasesGroup' => $dataProviderPurchasesGroup,
        ]);
    }

    public function actionMonthMarketExpense($year, $month)
    {
        $dataProviderMarketExpense = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason'),
             'pagination' => false,
         ]);

        return $this->render('month-details/market-expense', [
            'month'                     => $month,
            'year'                      => $year,
            'dataProviderMarketExpense' => $dataProviderMarketExpense,
        ]);
    }

    public function actionMonthDailyResult($year, $month)
    {
        //$incomingRevenue = QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id');
        $purchasesArray     = QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month, 'selected_date');
        $marketExpenseArray = QueryHelper::sumsSameResult(MarketExpense::tableName(), 'expense', $year, $month, 'selected_date');
        //var_dump($purchasesArray);
        //var_dump($marketExpenseArray);
        $result = [];
        foreach ($purchasesArray as $kayPurchases => $purchases)
        {
            foreach ($marketExpenseArray as $keyMarketExpense => $marketExpense)
            {
                if ($marketExpense['selected_date'] == $purchases['selected_date'])
                {
                    $result[$marketExpense['selected_date']]['result']        = $marketExpense['result'] + $purchases['result'];
                    $result[$marketExpense['selected_date']]['selected_date'] = $marketExpense['selected_date'];
                }
                elseif ($marketExpense['selected_date'] != $purchases['selected_date'])
                {
                    //$result[] = $marketExpense['result'];
                    $result[$marketExpense['selected_date']][] = $marketExpense['result'];
                    $result[$marketExpense['selected_date']][] = $marketExpense['selected_date'];
                }
            }
            //$result[$purchases['selected_date']][] = $purchases['result'];
            //$result[$purchases['selected_date']][] = $purchases['selected_date'];
        }
        var_dump($result);
        die();
        $dataProviderResult = new ArrayDataProvider
        ([
             'allModels'  => $result,
             'pagination' => false,
         ]);

        return $this->render('month-details/daily-result', [
            'month'              => $month,
            'year'               => $year,
            'dataProviderResult' => $dataProviderResult,
        ]);
    }
}