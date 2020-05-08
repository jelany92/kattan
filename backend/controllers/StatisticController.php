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
        $provider                    = new ArrayDataProvider([
                                                                 'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                             ]);
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id'),
             'pagination' => false,
         ]);

        return $this->render('month-details/income', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'modelIncomingRevenue'   => $dataProviderIncomingRevenue,
        ]);
    }

    public function actionMonthPurchases($year, $month)
    {
        $provider              = new ArrayDataProvider([
                                                           'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                       ]);
        $dataProviderPurchases = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);


        return $this->render('month-details/purchases', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'modelPurchases'         => $dataProviderPurchases,
        ]);
    }

    public function actionMonthPurchasesGroup($year, $month)
    {
        $provider                   = new ArrayDataProvider([
                                                                'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                            ]);
        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month),
             'pagination' => false,
         ]);


        return $this->render('month-details/purchases-group', [
            'statistikMonatProvider'     => $provider,
            'month'                      => $month,
            'year'                       => $year,
            'dataProviderPurchasesGroup' => $dataProviderPurchasesGroup,
        ]);
    }

    public function actionMonthMarketExpense($year, $month)
    {
        $provider                  = new ArrayDataProvider([
                                                               'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                           ]);
        $dataProviderMarketExpense = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason'),
             'pagination' => false,
         ]);

        return $this->render('month-details/market-expense', [
            'statistikMonatProvider'    => $provider,
            'month'                     => $month,
            'year'                      => $year,
            'dataProviderMarketExpense' => $dataProviderMarketExpense,
        ]);
    }
}