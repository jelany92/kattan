<?php

namespace backend\controllers;

use backend\models\IncomingRevenue;
use common\components\QueryHelper;
use Yii;
use backend\models\Purchases;
use backend\models\searchModel\PurchasesSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;

/**
 * PurchasesController implements the CRUD actions for Purchases model.
 */
class PurchasesController extends Controller
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
     * Lists all Purchases models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $modelPurchases = new Purchases();
        $result         = '';
        $show           = false;
        if ($modelPurchases->load(Yii::$app->request->post()))
        {
            $show = true;

            $result = QueryHelper::sumsSearchResult('purchases', 'purchases', 'reason', $modelPurchases->reason, $modelPurchases->from, $modelPurchases->to);
        }

        $searchModel  = new PurchasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/purchases/index', [
            'model'        => $modelPurchases,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
            'result'       => $result,
            'show'         => $show,
        ]);
    }

    /**
     * @return int|mixed|string|\yii\console\Response
     * @throws \yii\base\InvalidRouteException
     * @throws \yii\console\Exception
     */
    public function actionCreate()
    {
        $model = new Purchases();

        $date                 = Yii::$app->request->post('date');
        $model->selected_date = $date;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->company_id = Yii::$app->user->id;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء مصروف لليوم'));
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);
        }
        $reasonList = ArrayHelper::map(Purchases::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/purchases/create', [
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
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث مصروف لليوم') . ' ' . $model->selected_date);
            return Yii::$app->runAction('site/view', ['date' => $model->selected_date]);

        }
        $reasonList = ArrayHelper::map(Purchases::find()->select('reason')->andWhere(['company_id' => Yii::$app->user->id])->groupBy(['reason'])->all(), 'reason', 'reason');
        return $this->render('/supermarket/purchases/update', [
            'model'      => $model,
            'reasonList' => $reasonList,
        ]);
    }

    /**
     * @param $id
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $date  = $model->selected_date;
        $model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم مسح المحتوى'));
        return Yii::$app->runAction('site/view', ['date' => $date]);
    }

    /**
     * Finds the Purchases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Purchases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Purchases::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * @return Response
     */
    public function actionExport(): Response
    {
        $exporter = new Spreadsheet([
                                        'dataProvider' => new ActiveDataProvider([
                                                                                     'query' => Purchases::find()->select([
                                                                                                                              'selected_date',
                                                                                                                              'purchases',
                                                                                                                              'reason',
                                                                                                                          ])->andWhere([
                                                                                                                                           'company_id' => Yii::$app->user->id,
                                                                                                                                       ]),
                                                                                 ]),
                                    ]);

        $columnNames = [
            'selected_date',
            'purchases',
            'reason',
        ];

        $exporter->columns = $columnNames;
        return $exporter->send('items.xls');
    }
}
