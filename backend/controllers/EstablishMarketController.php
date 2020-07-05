<?php

namespace backend\controllers;

use Yii;
use backend\models\EstablishMarket;
use backend\models\searchModel\EstablishMarketSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EstablishMarketController implements the CRUD actions for EstablishMarket model.
 */
class EstablishMarketController extends Controller
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
     * Lists all EstablishMarket models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new EstablishMarketSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/establish-market/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new EstablishMarket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EstablishMarket();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            return $this->redirect(['/establish-market/index']);
        }

        return $this->render('/supermarket/establish-market/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing EstablishMarket model.
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

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            return $this->redirect(['/establish-market/index']);

        }

        return $this->render('/supermarket/establish-market/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing EstablishMarket model.
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

        Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
        return $this->redirect(['/establish-market/index']);
    }

    /**
     * Finds the EstablishMarket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return EstablishMarket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EstablishMarket::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
