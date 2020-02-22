<?php

namespace backend\controllers;

use backend\models\InvoicesPhoto;
use backend\models\PurchaseInvoices;
use common\components\QueryHelper;
use common\models\ArticleInfo;
use common\models\ArticlePrice;
use common\models\searchModel\ArticlePriceSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * ArticlePriceController implements the CRUD actions for ArticlePrice model.
 */
class ArticlePriceController extends Controller
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
     * Lists all ArticlePrice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ArticlePriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model        = new ArticlePrice();
        if ($searchModel->load(Yii::$app->request->post()))
        {
            $model->articleName = $searchModel->articleName;
            $query              = (new Query())->select([
                'ap.article_total_prise',
                'ap.article_prise_per_piece',
                'ap.selected_date',
                'ai.article_name_ar',
                'ai.article_quantity',
                'ai.article_unit',
                'ip.photo_path',
                'pi.seller_name',
            ])->from(['ap' => ArticlePrice::tableName()])->innerJoin(['ai' => ArticleInfo::tableName()], ['ap.id' => new Expression('ap.article_info_id')])->innerJoin(['pi' => PurchaseInvoices::tableName()], ['ap.purchase_invoices_id' => new Expression('pi.id')])->innerJoin(['ip' => InvoicesPhoto::tableName()], ['pi.id' => new Expression('ip.purchase_invoices_id')])->andWhere([
                    'Like',
                    'ai.article_name_ar',
                    $searchModel->articleName,
                ])->groupBy(['ai.article_name_ar']);
            $dataProvider       = new ActiveDataProvider([
                'query' => $query,
            ]);
        }
        return $this->render('index', [
            'model'        => $model,
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticlePrice model.
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
     * @param int $purchaseInvoicesId
     *
     * @return string|Response
     */
    public function actionCreate(int $purchaseInvoicesId)
    {
        $model                       = new ArticlePrice();
        $model->purchase_invoices_id = $purchaseInvoicesId;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->article_prise_per_piece = $model->article_total_prise / $model->article_count;
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            $model->save();
            /*     $model = new ArticlePrice();
                 $model->purchase_invoices_id = 1;
                 $model->selected_date = '2020-01-24';
                 $articleList  = ArrayHelper::map(ArticleInfo::find()->all(),'id', 'article_name_ar');
                 return $this->render('create', [
                     'model'        => $model,
                     'articleList'  => $articleList,
                 ]);*/

            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }

        $articleList = ArrayHelper::map(ArticleInfo::find()->all(), 'id', 'article_name_ar');
        return $this->render('create', [
            'model'       => $model,
            'articleList' => $articleList,
        ]);
    }

    /**
     * Updates an existing ArticlePrice model.
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
            $model->article_prise_per_piece = $model->article_total_prise / $model->article_count;
            $model->save();
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }
        $articleList = ArrayHelper::map(ArticleInfo::find()->all(), 'id', 'article_name_ar');
        return $this->render('update', [
            'model'       => $model,
            'articleList' => $articleList,
        ]);
    }

    /**
     * Deletes an existing ArticlePrice model.
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
     * Finds the ArticlePrice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ArticlePrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticlePrice::findOne($id)) !== null)
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
        $articlePrice = new ActiveDataProvider([
            'query' => ArticlePrice::find()->select([
                'article_info_id',
                'purchase_invoices_id',
                'article_total_prise',
                'article_prise_per_piece',
                'selected_date',
            ]),
        ]);
        $columnNames  = [
            'articleInfo.article_name_ar',
            'purchaseInvoices.seller_name',
            'article_total_prise',
            'article_prise_per_piece',
            'selected_date',
        ];
        return QueryHelper::fileExport($articlePrice, $columnNames, 'Article_Price.xls');

    }
}
