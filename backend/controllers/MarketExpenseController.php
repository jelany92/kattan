<?php

namespace backend\controllers;

use backend\models\IncomingRevenue;
use common\components\QueryHelper;
use Yii;
use backend\models\MarketExpense;
use backend\models\searchModel\MarketExpenseSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarketExpenseController implements the CRUD actions for MarketExpense model.
 */
class MarketExpenseController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MarketExpense models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new MarketExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('/supermarket/market-expense/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return int|mixed|string|\yii\console\Response
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionCreate()
    {
        $model                = new MarketExpense();
        $date                 = Yii::$app->request->post('date');
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'Market expense was created for today') . ' ' . $model->selected_date);
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }
        $reasonList = ArrayHelper::map(MarketExpense::find()->select('reason')->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/market-expense/create', [
            'model'      => $model,
            'reasonList' => $reasonList,
        ]);
    }

    /**
     * @param int $id
     *
     * @return int|mixed|string|\yii\console\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث مصروف للماركت لليوم') . ' ' . $model->selected_date);
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }

        $reasonList = ArrayHelper::map(MarketExpense::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/market-expense/update', [
            'model'      => $model,
            'reasonList' => $reasonList,

        ]);
    }

    /**
     * @param $id
     *
     * @return int|mixed|\yii\console\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $date  = $model->selected_date;
        $model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم حذف مصروف لليوم') . ' ' . $model->selected_date);
        return Yii::$app->runAction('site/view', ['date' => $date]);
    }

    /**
     * Finds the MarketExpense model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return MarketExpense the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MarketExpense::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
