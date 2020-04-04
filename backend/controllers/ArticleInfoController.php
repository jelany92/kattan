<?php

namespace backend\controllers;

use common\components\FileUpload;
use common\models\Category;
use Yii;
use common\models\ArticleInfo;
use common\models\searchModel\ArticleInfoSearch;
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleInfoController implements the CRUD actions for ArticleInfo model.
 */
class ArticleInfoController extends Controller
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
     * Lists all ArticleInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new ArticleInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleInfo model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model                    = $this->findModel($id);
        $modelIncomingRevenue     = $model->articlePrices;
        $dataProviderArticlePrice = new ArrayDataProvider([
            'allModels'  => $modelIncomingRevenue,
            'pagination' => false,
        ]);
        return $this->render('view', [
            'model'                    => $this->findModel($id),
            'dataProviderArticlePrice' => $dataProviderArticlePrice,
        ]);
    }

    /**
     * Creates a new ArticleInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleInfo();

        $searchModel  = new ArticleInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $fileUrls     = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->save();
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            $model               = new ArticleInfo();
            $model->category_id  = 7;
            $model->article_unit = 'K';
            $articleList         = ArrayHelper::map(Category::find()->all(), 'id', 'category_name');
            return $this->render('create', [
                'model'       => $model,
                'articleList' => $articleList,
                'fileUrls'    => $fileUrls,
            ]);
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }

        $articleList = ArrayHelper::map(Category::find()->all(), 'id', 'category_name');
        return $this->render('create', [
            'model'       => $model,
            'articleList' => $articleList,
            'fileUrls'    => $fileUrls,

        ]);
    }

    /**
     * Updates an existing ArticleInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model    = $this->findModel($id);
        $fileUrls = '';
        if ($model->article_photo != null)
        {
            $fileUrls = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryArticle'], $model->article_photo);
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $fileUpload = new FileUpload();
            $fileUpload->getFileUpload($model, 'file', 'article_photo');
            $model->save();
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }

        $articleList = Category::getCategoryList();
        return $this->render('update', [
            'model'       => $model,
            'articleList' => $articleList,
            'fileUrls'    => $fileUrls,
        ]);
    }

    /**
     * Deletes an existing ArticleInfo model.
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
     * Finds the ArticleInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ArticleInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleInfo::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
