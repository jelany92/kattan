<?php

namespace backend\controllers;

use common\components\FileUpload;
use common\controller\BaseController;
use common\models\AdminUser;
use common\models\BookAuthorName;
use common\models\BookGallery;
use common\models\GalleryBookForm;
use common\models\GallerySaveCategory;
use common\models\Subcategory;
use common\models\UserModel;
use Yii;
use common\models\DetailGalleryArticle;
use common\models\searchModel\DetailGalleryArticlelSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DetailGalleryArticleController implements the CRUD actions for DetailGalleryArticle model.
 */
class DetailGalleryArticleController extends BaseController
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
     * @param string|null $mainCategoryName
     * @param string|null $subcategoryId
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionIndex(string $mainCategoryName = null, int $subcategoryId = null)
    {
        $mainCategoryNames = DetailGalleryArticle::find()->select('main_category.category_name')->innerJoinWith('mainCategory')->andWhere(['detail_gallery_article.company_id' => Yii::$app->user->id])->distinct(true)->createCommand()->queryAll(\PDO::FETCH_COLUMN);
        $subcategoryNames  = DetailGalleryArticle::find()->select('subcategory.id,subcategory.subcategory_name')->innerJoinWith('mainCategory')->innerJoinWith('subcategories')->andWhere(['detail_gallery_article.company_id' => Yii::$app->user->id, 'main_category.category_name' => $mainCategoryName])->distinct(true)->createCommand()->queryAll(\PDO::FETCH_KEY_PAIR,\PDO::FETCH_COLUMN);
        $searchModel       = new DetailGalleryArticlelSearch();
        $dataProvider      = $searchModel->search(Yii::$app->request->queryParams, $mainCategoryName, $subcategoryId);
        return $this->render('index', [
            'mainCategoryNames' => $mainCategoryNames,
            'subcategoryNames'  => $subcategoryNames,
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
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
        $photoFileList        = [];
        $pdfFileList          = [];

        if ($modelGalleryBookForm->load(Yii::$app->request->post()) && $modelGalleryBookForm->validate())
        {
            $transaction = Yii::$app->db->beginTransaction();
            try
            {
                $modelUser                        = AdminUser::find()->andWhere(['id' => Yii::$app->user->id])->one();
                $modelGalleryBookForm->company_id = Yii::$app->user->id;
                $modelGalleryBookForm->type       = $modelUser->category;
                $modelDetailGalleryArticle        = new DetailGalleryArticle();
                $modelDetailGalleryArticle->saveDetailGalleryArticle($modelGalleryBookForm);
                foreach ($modelGalleryBookForm->subcategory_id as $category)
                {
                    $modelGallerySaveCategory = new GallerySaveCategory();
                    if (!is_numeric($category))
                    {
                        $modelSubcategory = new Subcategory();
                        $modelSubcategory->saveSubcategory($modelGalleryBookForm->main_category_id, $category);
                        $modelGallerySaveCategory->subcategory_id = $modelSubcategory->id;
                    }
                    else
                    {
                        $modelGallerySaveCategory->subcategory_id = $category;
                    }
                    $modelGallerySaveCategory->detail_gallery_article_id = $modelDetailGalleryArticle->id;
                    $modelGallerySaveCategory->save();
                }
                $modelBookAuthorName = BookAuthorName::find()->andWhere(['name' => $modelGalleryBookForm->authorName])->one();
                if ($modelBookAuthorName == null)
                {
                    $modelBookAuthorName = new BookAuthorName();
                    $modelBookAuthorName->name = $modelGalleryBookForm->authorName;
                    $modelBookAuthorName->save();
                }
                $modelBookGallery = new BookGallery();
                $modelBookGallery->saveDetailBookGallery($modelGalleryBookForm, $modelDetailGalleryArticle->id, $modelBookAuthorName->id);
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
            'model'                => $modelGalleryBookForm,
            'modelGalleryBookForm' => $modelGalleryBookForm,
            'fileUrlsPhoto'        => $fileUrlsPhoto,
            'fileUrlsPdf'          => $fileUrlsPdf,
            'photoFileList'        => $photoFileList,
            'pdfFileList'          => $pdfFileList,
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
        $fileUrlsPhoto   = '';
        $photoFileList[] = [
            'key' => Yii::$app->params['uploadDirectoryBookGalleryPhoto'],
        ];
        if ($modelGalleryBookForm->book_photo != null)
        {
            $fileUrlsPhoto = FileUpload::getFileUrl(Yii::$app->params['uploadDirectoryBookGalleryPhoto'], $modelBookGallery->book_photo);
        }
        $fileUrlsPdf   = '';
        $pdfFileList[] = [
            'key' => Yii::$app->params['uploadDirectoryBookGalleryPdf'],
        ];
        if ($modelGalleryBookForm->book_pdf != null)
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
                GallerySaveCategory::deleteAll(['detail_gallery_article_id' => $modelDetailGalleryArticle->id]);
                foreach ($modelGalleryBookForm->subcategory_id as $category)
                {
                    $modelGallerySaveCategory = new GallerySaveCategory();
                    if (!is_numeric($category))
                    {
                        $modelSubcategory = new Subcategory();
                        $modelSubcategory->saveSubcategory($modelGalleryBookForm->main_category_id, $category);
                        $modelGallerySaveCategory->subcategory_id = $modelSubcategory->id;
                    }
                    else
                    {
                        $modelGallerySaveCategory->subcategory_id = $category;
                    }
                    $modelGallerySaveCategory->detail_gallery_article_id = $modelDetailGalleryArticle->id;
                    $modelGallerySaveCategory->save();
                }

                $modelBookGallery = $modelDetailGalleryArticle->bookGalleries;

                $modelBookAuthorName = BookAuthorName::find()->andWhere(['name' => $modelGalleryBookForm->authorName])->one();
                if ($modelBookAuthorName == null)
                {
                    $modelBookAuthorName = new BookAuthorName();
                    $modelBookAuthorName->name = $modelGalleryBookForm->authorName;
                    $modelBookAuthorName->save();
                }
                $modelBookGallery->saveDetailBookGallery($modelGalleryBookForm, $modelDetailGalleryArticle->id, $modelBookAuthorName->id);
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
            'photoFileList'        => $photoFileList,
            'pdfFileList'          => $pdfFileList,
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
     * @param int    $id
     * @param string $fileName
     * @param string $column
     *
     * @return array|void
     */
    public function actionDeleteFile(int $id, string $fileName, string $column)
    {
        $isDeleted                  = false;
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax)
        {
            $bookGallery = BookGallery::findOne(['detail_gallery_article_id' => $id]);
            if ($bookGallery instanceof BookGallery)
            {
                $filePath          = Yii::$app->request->post('key');
                $fileBookPhotoPath = $bookGallery->getAbsolutePath($filePath, $fileName);
                if (file_exists($fileBookPhotoPath))
                {
                    unlink($fileBookPhotoPath);
                    $bookGallery->$column = null;
                    $bookGallery->save();
                    $isDeleted = true;
                }
            }
        }
        return $isDeleted ? Yii::$app->session->addFlash('success', Yii::t('app', 'done')) : ['error' => Yii::t('app', 'File konnte nicht erfolgreich gelöscht werden.')];
    }

    /**
     * @param int $id
     *
     * @return \yii\console\Response|Response
     * @throws NotFoundHttpException
     */
    public function actionDownload(int $id)
    {
        $model = $this->findModel($id);
        if (isset($model->bookGalleries->book_pdf))
        {
            $filesPath = $model->bookGalleries->getAbsolutePath(Yii::$app->params['uploadDirectoryBookGalleryPdf'], $model->bookGalleries->book_pdf);
            if (file_exists($filesPath))
            {
                Yii::$app->session->addFlash('success', Yii::t('app', 'تم تحميل الكتاب'));
                return \Yii::$app->response->sendFile($filesPath);
            }
        }
        Yii::$app->session->addFlash('error', Yii::t('app', 'الكتاب غير متوفر حاليا'));
        return $this->redirect(Yii::$app->request->referrer);
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
