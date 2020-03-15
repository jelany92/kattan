<?php

namespace backend\controllers;

use common\components\QueryHelper;
use Yii;
use backend\models\MarketExpense;
use backend\models\searchModel\MarketExpenseSearch;
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
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new MarketExpenseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $modelMarketExpense = new MarketExpense();
        $result             = '';
        $show               = false;
        if ($modelMarketExpense->load(Yii::$app->request->post()))
        {
            $show   = true;
            $result = QueryHelper::sumsSearchResult('market_expense', 'expense', 'reason', $modelMarketExpense->reason, $modelMarketExpense->from, $modelMarketExpense->to);
        }
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'model'        => $modelMarketExpense,
            'result'       => $result,
            'show'         => $show,
        ]);
    }

    /**
     * Creates a new MarketExpense model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MarketExpense();
        $date = Yii::$app->request->post('date');
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء مصروف للماركت لليوم') . ' ' . $model->selected_date);
            return $this->redirect([
                'index',
            ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MarketExpense model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث مصروف للماركت لليوم') . ' ' . $model->selected_date);
            return $this->redirect([
                'index',
            ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MarketExpense model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
