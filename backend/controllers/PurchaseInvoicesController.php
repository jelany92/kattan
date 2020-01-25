<?php

namespace backend\controllers;

use backend\models\InvoicesPhoto;
use Yii;
use backend\models\PurchaseInvoices;
use backend\models\searchModel\PurchaseInvoicesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * PurchaseInvoicesController implements the CRUD actions for PurchaseInvoices model.
 */
class PurchaseInvoicesController extends Controller
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
     * Lists all PurchaseInvoices models.
     * @return string
     */
    public function actionIndex() : string
    {
        $searchModel  = new PurchaseInvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseInvoices model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PurchaseInvoices model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model           = new PurchaseInvoices();
        $fileUrls     = [];
        $invoiceFileList = [];


        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $model->save();
                $model->saveInvoicesPhoto();
                $transaction->commit();
            } catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            if ($model->save())
            {
                return $this->redirect([
                    'view',
                    'id' => $model->id,
                ]);
            }
        }

        return $this->render('create', [
            'model'           => $model,
            'fileUrls'        => $fileUrls,
            'invoiceFileList' => $invoiceFileList,

        ]);
    }

    /**
     * @param int $id
     *
     * @return string|Response
     * @throws NotFoundHttpException
     * @throws \yii\base\Exception
     */
    public function actionUpdate(int $id)
    {
        $model           = $this->findModel($id);
        $fileUrls        = [];
        $invoiceFileList = [];
        foreach ($model->invoicePhotos as $item)
        {
            /* @var $item InvoicesPhoto */

            $fileUrls[]        = $item->getFileUrl();
            $invoiceFileList[] = [
                'key' => $item->id,
            ];
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            $model->saveInvoicesPhoto();
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }

        return $this->render('update', [
            'model'           => $model,
            'fileUrls'        => $fileUrls,
            'invoiceFileList' => $invoiceFileList,

        ]);
    }

    /**
     * delete delete file from input field
     *
     * @return array|int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteFile()
    {
        $isDeleted                  = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax)
        {
            $id            = Yii::$app->request->post('key');
            $imageToDelete = InvoicesPhoto::findOne($id);
            if ($imageToDelete instanceof InvoicesPhoto)
            {
                $filePath = $imageToDelete->getAbsolutePath();
                if (file_exists($filePath))
                {
                    unlink($filePath);
                }
                $isDeleted = $imageToDelete->delete();

            }
        }
        return $isDeleted ? 1 : ['error' => Yii::t('app', 'File konnte nicht erfolgreich gelöscht werden.')];
    }

    /**
     * @param $id
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
     * Finds the PurchaseInvoices model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return PurchaseInvoices the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = PurchaseInvoices::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
