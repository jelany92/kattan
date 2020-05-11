<?php

namespace backend\controllers;

use backend\models\Capital;
use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\PurchaseInvoices;
use backend\models\Purchases;
use backend\models\TaxOffice;
use common\models\ArticleInfo;
use common\models\Category;
use common\models\CustomerEmployer;
use common\models\Order;
use Yii;
use common\models\UserModel;
use common\models\searchModel\UserModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserModelController implements the CRUD actions for UserModel model.
 */
class UserModelController extends Controller
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
     * Lists all UserModel models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new UserModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserModel model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\Exception
     */
    public function actionCreate()
    {
        $model = new UserModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->password_hash   = Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->repeat_password = $model->password_hash;
            $model->auth_key        = Yii::$app->security->generateRandomString();
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء متجر جديد'));
            return $this->redirect([
                                       '/site/login',
                                   ]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserModel model.
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
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث المتجر'));
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
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
        $model = $this->findModel($id);

        // Order::deleteAll(['user_id' => $id]);
        ArticleInfo::deleteAll(['company_id' => $id]);
        Category::deleteAll(['company_id' => $id]);
        Capital::deleteAll(['company_id' => $id]);
        CustomerEmployer::deleteAll(['user_id' => $id]);
        //Debt::deleteAll(['company_id' => $id]);
        IncomingRevenue::deleteAll(['company_id' => $id]);
        MarketExpense::deleteAll(['company_id' => $id]);
        Purchases::deleteAll(['company_id' => $id]);
        PurchaseInvoices::deleteAll(['company_id' => $id]);
        //SalaryOfEmploy::deleteAll(['company_id' => $id]);
        TaxOffice::deleteAll(['company_id' => $id]);
        //$model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم حذف المستخدم'));
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return UserModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
