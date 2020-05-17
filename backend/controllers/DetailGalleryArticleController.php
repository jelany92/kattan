<?php

namespace backend\controllers;

use common\components\FileUpload;
use common\models\BookGallery;
use common\models\GalleryBookForm;
use common\models\UserModel;
use Yii;
use common\models\DetailGalleryArticle;
use common\models\searchModel\DetailGalleryArticlelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * DetailGalleryArticleController implements the CRUD actions for DetailGalleryArticle model.
 */
class DetailGalleryArticleController extends Controller
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
     * Lists all DetailGalleryArticle models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new DetailGalleryArticlelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DetailGalleryArticle model.
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
     * @throws \Exception
     */
    public function actionCreate()
    {
        $modelGalleryBookForm = new GalleryBookForm();
        $fileUrlsPhoto        = '';
        $fileUrlsPdf          = '';

        if ($modelGalleryBookForm->load(Yii::$app->request->post()) && $modelGalleryBookForm->validate())
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $modelUser                        = UserModel::find()->andWhere(['id' => Yii::$app->user->id])->one();
                $modelGalleryBookForm->company_id = Yii::$app->user->id;
                $modelGalleryBookForm->type       = $modelUser->category;
                $modelDetailGalleryArticle        = new DetailGalleryArticle();
                $modelDetailGalleryArticle->saveDetailGalleryArticle($modelGalleryBookForm);
                $modelBookGallery = new BookGallery();
                $modelBookGallery->saveDetailBookGallery($modelGalleryBookForm, $modelDetailGalleryArticle->id);
                $transaction->commit();
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }

            return $this->redirect([
                                       'view',
                                       'id' => $modelDetailGalleryArticle->id,
                                   ]);
        }
        return $this->render('create', [
            'model'         => $modelGalleryBookForm,
            'fileUrlsPhoto' => $fileUrlsPhoto,
            'fileUrlsPdf'   => $fileUrlsPdf,
        ]);
    }

    /**
     * Updates an existing DetailGalleryArticle model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model                = $this->findModel($id);
        $modelGalleryBookForm = new GalleryBookForm();
        $modelGalleryBookForm->setAttributeForDetailGalleryArticle($model);
        $modelBookGallery = $model->bookGalleries;
        $modelGalleryBookForm->setAttributeForBookGallery($modelBookGallery, $id);
        $fileUrlsPhoto = '';
        if ($modelGalleryBookForm->book_photo != null)
        {
            $fileUrlsPhoto = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryBookGalleryPhoto'], 'o_' . $modelBookGallery->book_photo);
        }
        $fileUrlsPdf = '';
        if ($modelGalleryBookForm->book_photo != null)
        {
            $fileUrlsPdf = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryBookGalleryPdf'], $modelBookGallery->book_pdf);
        }
        if ($modelGalleryBookForm->load(Yii::$app->request->post()) && $modelGalleryBookForm->validate())
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $modelDetailGalleryArticle = DetailGalleryArticle::find()->andWhere(['id' => $model->id])->one();
                $modelDetailGalleryArticle->saveDetailGalleryArticle($modelGalleryBookForm);
                $modelBookGallery                    = $modelDetailGalleryArticle->bookGalleries;
                var_dump($modelGalleryBookForm->file_book_pdf);
                $modelGalleryBookForm->file_book_pdf = $modelGalleryBookForm->getFileName();
                var_dump($modelGalleryBookForm->file_book_pdf);
                die();
                $modelBookGallery->saveDetailBookGallery($modelGalleryBookForm, $modelDetailGalleryArticle->id);
                Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
                $transaction->commit();
            }
            catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            return $this->redirect([
                                       'view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('update', [
            'modelGalleryBookForm' => $modelGalleryBookForm,
            'model'                => $model,
            'fileUrlsPhoto'        => $fileUrlsPhoto,
            'fileUrlsPdf'          => $fileUrlsPdf,
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
        BookGallery::deleteAll(['detail_gallery_article_id' => $id]);
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the DetailGalleryArticle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return DetailGalleryArticle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DetailGalleryArticle::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}