<?php

namespace backend\controllers;

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
     *
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
            $query              = (new Query())->select('*')->from(['ap' => ArticlePrice::tableName()])->innerJoin(['ai' => ArticleInfo::tableName()], ['ai.id' => new Expression('ap.article_info_id')])->andWhere([
                                                                                                                                                                                                                        'Like',
                                                                                                                                                                                                                        'ai.article_name_ar',
                                                                                                                                                                                                                        $searchModel->articleName,
                                                                                                                                                                                                                    ]);
            $dataProvider       = new ActiveDataProvider([
                                                             'query' => $query,
                                                         ]);
        }
        return $this->render('/supermarket/article-price/index', [
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
        return $this->render('/supermarket/article-price/view', [
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

        $articleList = ArrayHelper::map(ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'article_name_ar');
        return $this->render('/supermarket/article-price/create', [
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
        $articleList = ArrayHelper::map(ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'article_name_ar');
        return $this->render('/supermarket/article-price/update', [
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

        return $this->redirect(['/supermarket/article-price/index']);
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
        $query = ArticlePrice::find()->select([
                                                  'article_price.article_info_id',
                                                  'article_price.purchase_invoices_id',
                                                  'article_price.article_total_prise',
                                                  'article_price.article_prise_per_piece',
                                                  'article_price.selected_date',
                                              ])->innerJoinWith('articleInfo')->andWhere(['company_id' => Yii::$app->user->id]);
        if (0 < $query->count())
        {
            $articlePrice = new ActiveDataProvider([
                                                       'query' => $query,
                                                   ]);
            $columnNames  = [
                'articleInfo.article_name_ar',
                'purchaseInvoices.seller_name',
                'article_total_prise',
                'article_prise_per_piece',
                'selected_date',
            ];
            Yii::$app->session->addFlash('success', 'done');
            return QueryHelper::fileExport($articlePrice, $columnNames, 'Article_Price.xls');
        }

        Yii::$app->session->addFlash('error', Yii::t('app', 'You dont have Article Prices'));
        return $this->redirect(Yii::$app->request->referrer);
    }
}
