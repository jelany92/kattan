<?php

namespace backend\controllers;

use backend\models\Capital;
use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\Purchases;
use backend\models\RevenueSupermarket;
use common\models\LoginForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\data\SqlDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\debug\models\timeline\DataProvider;
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
        return $this->render('index', [

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
        $incomingRevenues            = IncomingRevenue::find()->all();
        $purchases                   = Purchases::find()->all();
        $marketExpense               = MarketExpense::find()->all();
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
            $resultSum             = $time->daily_incoming_revenue - $manyPurchasesInOneDay['result'];
            $Event                 = new \yii2fullcalendar\models\Event();
            $Event->id             = $time['id'];
            $Event->title          = 'الناتج اليومي: ' . $resultSum;
            $Event->start          = $time['selected_date'];
            $Event->color          = '#03c94c';
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
     *
     * @return string
     * @throws \Exception
     */
    public function actionMonthView($year, $month)
    {
        $monthData                   = IncomingRevenue::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue');
        $provider                    = new ArrayDataProvider([
            'allModels' => $monthData,
        ]);
        $modelIncomingRevenue        = IncomingRevenue::getDailyDataIncomingRevenue($year, $month);
        $dataProviderIncomingRevenue = new ArrayDataProvider
        ([
            'allModels'  => $modelIncomingRevenue,
            'pagination' => false,
        ]);

        $modelPurchases        = Purchases::getDailyPurchases($year, $month);
        $dataProviderPurchases = new ArrayDataProvider
        ([
            'allModels'  => $modelPurchases,
            'pagination' => false,
        ]);
        return $this->render('month', [
            'statistikMonatProvider' => $provider,
            // name für monat  nur variable
            'month'                  => $month,
            'year'                   => $year,
            'modelIncomingRevenue'   => $dataProviderIncomingRevenue,
            'modelPurchases'         => $dataProviderPurchases,

        ]);

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

        $monthData = IncomingRevenue::getYearData($year, 'incoming_revenue', 'daily_incoming_revenue');
        $provider  = new ArrayDataProvider([
            'allModels' => $monthData,
        ]);
        for ($month = 1; $month <= 12; $month++)
        {
            $modelIncomingRevenue[] = [IncomingRevenue::getMonthData($year, $month, 'incoming_revenue', 'daily_incoming_revenue')];
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
        $show = true;
        // check if holiday
        $isIncomingRevenueIWrote = IncomingRevenue::find()->forDate($date)->exists();
        if (new \DateTime() < $date)
        {
            $isFuture = true;
        }
        else
        {
            $isFuture = false;
        }
        if ($isIncomingRevenueIWrote)
        {
            $show = false;
        }
        return $this->render('view', [
            'date'       => $date->format('d.m.Y'),
            'showCreate' => $show,
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
