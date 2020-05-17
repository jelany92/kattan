<?php

namespace backend\controllers;

use backend\models\Capital;
use backend\models\searchModel\CapitalSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CapitalController implements the CRUD actions for Capital model.
 */
class CapitalController extends Controller
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
     * Lists all Capital models.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(): string
    {
        $searchModel                = new CapitalSearch();
        $dataProvider               = $searchModel->search(Yii::$app->request->queryParams);
        $tableInformationEntry      = Capital::find()->select([
                                                                  'amount' => 'sum(amount)',
                                                                  'name',
                                                              ])->andWhere([
                                                                               'status'     => 'Entry',
                                                                               'company_id' => Yii::$app->user->id,
                                                                           ])->groupBy('name')->createCommand()->queryAll();
        $tableInformationWithdrawal = Capital::find()->select([
                                                                  'amount' => 'sum(amount)',
                                                                  'name',
                                                              ])->andWhere([
                                                                               'status'     => 'Withdrawal',
                                                                               'company_id' => Yii::$app->user->id,
                                                                           ])->groupBy('name')->createCommand()->queryAll();
        $tableInformationStock      = Capital::find()->select([
                                                                  'stock' => "SUM(IF(status = 'Entry', amount, 0)) - SUM(IF(status = 'Withdrawal', amount, 0))",
                                                                  'name',
                                                              ])->andWhere([
                                                                               'company_id' => Yii::$app->user->id,
                                                                           ])->groupBy('name')->createCommand()->queryAll();
        return $this->render('/supermarket/capital/index', [
            'searchModel'                => $searchModel,
            'dataProvider'               => $dataProvider,
            'tableInformationEntry'      => $tableInformationEntry,
            'tableInformationWithdrawal' => $tableInformationWithdrawal,
            'tableInformationStock'      => $tableInformationStock,
        ]);
    }

    /**
     * Displays a single Capital model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('/capital/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Capital model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Capital();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء راس مال الماركت لليوم') . ' ' . $model->selected_date);
            return $this->redirect([
                                       '/capital/index',
                                   ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Capital model.
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
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث راس مال الماركت لليوم') . ' ' . $model->selected_date);
            return $this->redirect([
                                       '/capital/index',
                                   ]);
        }

        return $this->render('/supermarket/capital/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Capital model.
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

        return $this->redirect(['/supermarket/capital/index']);
    }

    /**
     * Finds the Capital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Capital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Capital::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
