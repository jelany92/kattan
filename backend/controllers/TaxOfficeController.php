<?php

namespace backend\controllers;

use backend\models\TaxOffice;
use backend\models\searchModel\TaxOfficeSearch;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * TaxOfficeController implements the CRUD actions for TaxOffice model.
 */
class TaxOfficeController extends Controller
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
     * Lists all TaxOffice models.
     *
     * @return mixed
     */
    public function actionIndex(): string
    {
        $searchModel  = new TaxOfficeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Creates a new TaxOffice model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $date                 = Yii::$app->request->post('date');
        $model                = new TaxOffice();
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            return $this->redirect([
                                       'index',
                                   ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TaxOffice model.
     * If update is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                                       'index',
                                   ]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the TaxOffice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return TaxOffice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = TaxOffice::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
