<?php

namespace backend\controllers;

use common\models\ArticleInfo;
use common\models\Category;
use Yii;
use common\models\ArticlePrice;
use common\models\searchModel\ArticlePriceSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii2tech\spreadsheet\Spreadsheet;

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
                'class' => VerbFilter::className(),
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
        $searchModel = new ArticlePriceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticlePrice model.
     * @param integer $id
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
     * Creates a new ArticlePrice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticlePrice();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->article_prise_per_piece = $model->article_total_prise / $model->article_count;
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            $model = new ArticlePrice();
            $model->selected_date = '2019-12-30';
            $articleList  = ArrayHelper::map(ArticleInfo::find()->all(),'id', 'article_name');
            return $this->render('create', [
                'model'        => $model,
                'articleList'  => $articleList,
            ]);

            return $this->redirect(['view', 'id' => $model->id]);
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $articleList  = ArrayHelper::map(ArticleInfo::find()->all(),'id', 'article_name');
        return $this->render('create', [
            'model'        => $model,
            'articleList'  => $articleList,
        ]);
    }

    /**
     * Updates an existing ArticlePrice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $articleList  = ArrayHelper::map(ArticleInfo::find()->all(),'id', 'article_name');
        return $this->render('update', [
            'model'        => $model,
            'articleList'  => $articleList,
        ]);
    }

    /**
     * Deletes an existing ArticlePrice model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
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
     * @param integer $id
     * @return ArticlePrice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticlePrice::findOne($id)) !== null) {
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
                'query' => ArticlePrice::find()->select([
                    'article_info_id',
                    'purchase_invoices_id',
                    'article_total_prise',
                    'article_prise_per_piece',
                    'selected_date',
                ]),
            ]),
        ]);

        $columnNames = [
            'articleInfo.article_name',
            'purchaseInvoices.seller_name',
            'article_total_prise',
            'article_prise_per_piece',
            'selected_date',
        ];

        $exporter->columns = $columnNames;
        return $exporter->send('Article_Price.xls');
    }
}
