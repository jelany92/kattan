<?php

namespace backend\controllers;

use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\Purchases;
use common\components\QueryHelper;
use common\models\LoginForm;
use common\models\UserModel;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => [
                            'login',
                            'error',
                        ],
                        'allow'   => true,
                    ],
                    [
                        'actions' => [
                            'logout',
                            'index',
                            'get-events',
                            'view',
                            'month-view',
                            'month-income',
                            'month-view-pdf',
                            'year-view',
                        ],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $modelUserModel = UserModel::find()->andWhere(['id' => Yii::$app->user->id])->one();
        if ($modelUserModel->category == 'Market')
        {
            return $this->render('market', [

            ]);
        }
        if ($modelUserModel->category == 'Programirung')
        {
            return $this->render('market', [

            ]);
        }
        return $this->render('market', [

        ]);
    }

    /**
     * @return array
     */
    public function actionGetEvents(): array
    {
        if (!(Yii::$app->request->isAjax))
        {
            die();
        }

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $incomingRevenues            = IncomingRevenue::find()->userId(Yii::$app->user->id)->all();
        $purchases                   = Purchases::find()->userId(Yii::$app->user->id)->all();
        $marketExpense               = MarketExpense::find()->userId(Yii::$app->user->id)->all();
        $events                      = [];

        // Zeigt all ArbeitsZeit für eingeloggt user von wann bis wann
        foreach ($incomingRevenues AS $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = 'الايراد: ' . $time->daily_incoming_revenue;
            $Event->start  = $time->selected_date;
            $Event->color  = '#36a6fc';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        foreach ($incomingRevenues AS $time)
        {
            $manyPurchasesInOneDay = (new Query())->from(['purchases'])->select(['result' => 'SUM(purchases)'])->andWhere(['selected_date' => $time['selected_date']])->one();
            $expense               = (new Query())->from(['market_expense'])->select(['result' => 'SUM(expense)'])->andWhere(['selected_date' => $time['selected_date']])->one();
            $dailyResult           = $time->daily_incoming_revenue - $manyPurchasesInOneDay['result'] - $expense['result'];
            $resultSum             = $dailyResult;
            $Event                 = new \yii2fullcalendar\models\Event();
            $Event->id             = $time['id'];
            $Event->title          = 'الناتج اليومي: ' . $resultSum;
            $Event->start          = $time['selected_date'];
            $Event->color          = '#03c94c'; // green
            $Event->allDay         = true;
            $events[]              = $Event;
        }

        foreach ($purchases AS $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = $time->reason . ': ' . $time->purchases;
            $Event->start  = $time->selected_date;
            $Event->color  = '#ff6666';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        foreach ($marketExpense AS $time)
        {
            $Event         = new \yii2fullcalendar\models\Event();
            $Event->id     = $time->id;
            $Event->title  = $time->reason . ': ' . $time->expense;
            $Event->start  = $time->selected_date;
            $Event->color  = '#ffc133';
            $Event->allDay = true;
            $events[]      = $Event;
        }

        return $events;
    }

    /**
     * Ansicht für Monat
     *
     * @param $year
     * @param $month
     * @param $year
     * @param $month
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionMonthView($year, $month, $view = 'month')
    {
        $provider                    = new ArrayDataProvider([
                                                                 'allModels' => QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue'),
                                                             ]);
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'incoming_revenue', 'daily_incoming_revenue', 'id'),
             'pagination' => false,
         ]);
        $dataProviderPurchases       = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);

        $dataProviderMarketExpense = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason'),
             'pagination' => false,
         ]);

        $dailyIncomingRevenue = QueryHelper::getResult($year, $month);
        $dataProviderDailyCash = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getResult($year, $month),
             'pagination' => false,
         ]);

        $dataProviderMarketExpenseGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(MarketExpense::tableName(), 'expense', $year, $month),
             'pagination' => false,
         ]);

        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month),
             'pagination' => false,
         ]);

        return $this->render($view, [
            'statistikMonatProvider'         => $provider,
            'month'                          => $month,
            'year'                           => $year,
            'modelIncomingRevenue'           => $dataProviderIncomingRevenue,
            'modelPurchases'                 => $dataProviderPurchases,
            'dataProviderMarketExpense'      => $dataProviderMarketExpense,
            'dataProviderMarketExpenseGroup' => $dataProviderMarketExpenseGroup,
            'dataProviderPurchasesGroup'     => $dataProviderPurchasesGroup,
            'dataProviderDailyCash'          => $dataProviderDailyCash,
        ]);
    }

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
        $dataProviderPurchases       = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'purchases', 'purchases', 'reason'),
             'pagination' => false,
         ]);

        $dataProviderMarketExpense = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason'),
             'pagination' => false,
         ]);

        $dailyIncomingRevenue = QueryHelper::getResult($year, $month);
        $dataProviderDailyCash = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::getResult($year, $month),
             'pagination' => false,
         ]);

        $dataProviderMarketExpenseGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(MarketExpense::tableName(), 'expense', $year, $month),
             'pagination' => false,
         ]);

        $dataProviderPurchasesGroup = new ArrayDataProvider
        ([
             'allModels'  => QueryHelper::sumsSameResult(Purchases::tableName(), 'purchases', $year, $month),
             'pagination' => false,
         ]);

        return $this->render('month-details/income', [
            'statistikMonatProvider'         => $provider,
            'month'                          => $month,
            'year'                           => $year,
            'modelIncomingRevenue'           => $dataProviderIncomingRevenue,
            'modelPurchases'                 => $dataProviderPurchases,
            'dataProviderMarketExpense'      => $dataProviderMarketExpense,
            'dataProviderMarketExpenseGroup' => $dataProviderMarketExpenseGroup,
            'dataProviderPurchasesGroup'     => $dataProviderPurchasesGroup,
            'dataProviderDailyCash'          => $dataProviderDailyCash,
        ]);
    }

    /**
     * @param $year
     * @param $month
     *
     * @return mixed
     * @throws \yii\web\HttpException
     */
    public function actionMonthViewPdf($year, $month)
    {
        $date                      = date('d.m.Y');
        $dataProviderMarketExpense = QueryHelper::getDailyInfo($year, $month, 'market_expense', 'expense', 'reason');
        $content                   = $this->render('month-pdf', [
            'year'                      => $year,
            'month'                     => $month,
            'dataProviderMarketExpense' => $dataProviderMarketExpense,
        ]);
        $pdf                       = Yii::$app->pdf;
        $mpdf                      = $pdf->api;
        $mpdf->SetHeader($date . ' Kattan Shop');
        print_r($content);
        die();
        $mpdf->WriteHtml($content);
        return $mpdf->Output($date, 'D');

    }

    /**
     * Ansicht für Jahr
     *
     * @param $year
     *
     * @return string
     * @throws \Exception
     */
    public function actionYearView($year)
    {

        $monthData = QueryHelper::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue');
        $provider  = new ArrayDataProvider([
                                               'allModels' => $monthData,
                                           ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [QueryHelper::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue')];
        }
        $dataProvider = new ArrayDataProvider([
                                                  'allModels'  => $modelIncomingRevenue,
                                                  'pagination' => false,
                                              ]);

        return $this->render('year', [
            'statistikMonatProvider' => $provider,
            'month'                  => $month,
            'year'                   => $year,
            'dataProvider'           => $dataProvider,
        ]);
    }

    /**
     * @param string $date
     *
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView(string $date)
    {
        $date = \DateTime::createFromFormat('Y-m-d', $date);
        if (!($date instanceof \DateTime))
        {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }
        Yii::$app->session->set('returnDate', $date->format('Y-m-d'));
        $showIncomingRevenue     = true;
        $isIncomingRevenueIWrote = IncomingRevenue::find()->forDate($date)->userId(Yii::$app->user->id)->exists();
        if ($isIncomingRevenueIWrote)
        {
            $showIncomingRevenue = false;
        }
        return $this->render('view', [
            'date'                      => $date->format('Y-m-d'),
            'showCreateIncomingRevenue' => $showIncomingRevenue,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }
        else
        {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
