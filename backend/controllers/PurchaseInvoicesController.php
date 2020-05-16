<?php

namespace backend\controllers;

use backend\models\InvoicesPhoto;
use backend\models\PurchaseInvoices;
use backend\models\searchModel\PurchaseInvoicesSearch;
use common\models\ArticlePrice;
use kartik\mpdf\Pdf;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;

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
    public function actionIndex(): string
    {
        $searchModel  = new PurchaseInvoicesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/purchase-invoices/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PurchaseInvoices model.
     *
     * @param integer $id
     * @param string  $view
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView(int $id, string $view = '/supermarket/purchase-invoices/view')
    {
        $model             = $this->findModel($id);
        $modelArticlePrice = new ActiveDataProvider([
            'query' => ArticlePrice::find()->andWhere(['purchase_invoices_id' => $id]),
        ]);
        return $this->render($view, [
            'model'                    => $model,
            'dataProviderArticlePrice' => $modelArticlePrice,

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
        $fileUrls        = [];
        $invoiceFileList = [];

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $model->save();
                $model->saveInvoicesFile();
                $transaction->commit();
            } catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            if ($model->save())
            {
                Yii::$app->session->addFlash('success', Yii::t('app', 'تم انشاء مصروف لليوم'));
                return $this->redirect([
                    '/purchase-invoices/index',
                ]);
            }
        }

        return $this->render('/supermarket/purchase-invoices/create', [
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
            $model->saveInvoicesFile();
            Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحديث مصروف لليوم'));
            return $this->redirect([
                '/purchase-invoices/index',
                'id' => $model->id,
            ]);
        }

        return $this->render('/supermarket/purchase-invoices/update', [
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


    /**
     * int $purchaseInvoicesId
     * @return Response
     */
    public function actionExport(int $purchaseInvoicesId): Response
    {
        $exporter = new Spreadsheet([
            'dataProvider' => new ActiveDataProvider([
                'query' => ArticlePrice::find()->select([
                    'article_info_id',
                    'purchase_invoices_id',
                    'article_total_prise',
                    'article_prise_per_piece',
                    'selected_date',
                ])->andWhere(['purchase_invoices_id' => $purchaseInvoicesId]),
            ]),
        ]);

        $columnNames = [
            'articleInfo.article_name_ar',
            'purchaseInvoices.seller_name',
            'article_total_prise',
            'article_prise_per_piece',
            'selected_date',
        ];

        $exporter->columns = $columnNames;
        return $exporter->send('Article_Price.xls');
    }

    /**
     * @param $id
     *
     * @return string
     * @throws NotFoundHttpException
     * @throws \Mpdf\MpdfException
     */
    public function actionViewPdf($purchaseInvoicesId)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $model             = $this->findModel($purchaseInvoicesId);
        $modelArticlePrice = new ActiveDataProvider([
            'query' => ArticlePrice::find()->andWhere(['purchase_invoices_id' => $purchaseInvoicesId]),
        ]);
        $view = '@backend/components/view/pdf-file/price-per-invoices-pdf.php';
        $content = $this->render($view, [
            'model'                    => $model,
            'dataProviderArticlePrice' => $modelArticlePrice,

        ]);
        //print_r($content);die();
        /* @var $mpdf \Mpdf\Mpdf */
        $date    = date('d.m.Y');

        $pdf     = Yii::$app->pdf;
        $mpdf    = $pdf->api;
        $mpdf->SetHeader($date . ' Kattan Shop');
        $mpdf->WriteHtml($content);
        return $mpdf->Output($date);
    }
}
