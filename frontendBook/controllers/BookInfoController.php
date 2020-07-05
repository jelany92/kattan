<?php

namespace frontendBook\controllers;

use backend\models\searchModel\MainCategorySearch;
use common\models\BookGallery;
use common\models\DetailGalleryArticle;
use common\models\MainCategory;
use common\models\searchModel\BookAuthorNameSearch;
use common\models\Subcategory;
use Yii;
use yii\web\Controller;

/**
 * Site controller
 */
class BookInfoController extends Controller
{
    /**
     * Displays Author.
     *
     * @return mixed
     */
    public function actionAuthor()
    {
        $searchModel  = new BookAuthorNameSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('author', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSubcategories()
    {
        $subcategories = Subcategory::find()->all();
        return $this->render('subcategories', [
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @param  string $subcategoryName
     *
     * @return string
     * @throws \yii\db\Exception
     */
    public function actionSubcategory(string $subcategoryName)
    {
        $subcategories = Subcategory::find()->andWhere(['subcategory_name' => $subcategoryName])->all();
        return $this->render('subcategory', [
            'subcategories' => $subcategories,
        ]);
    }

    /**
     * Displays Main Category.
     *
     * @return mixed
     */
    public function actionMainCategory()
    {
        $mainCategories = MainCategory::find()->andWhere(['company_id' => 2])->all();

        return $this->render('main-category', [
            'mainCategories' => $mainCategories,
        ]);
    }

    /**
     * Displays Book Details.
     *
     * @param int $detailGalleryArticleId
     *
     * @return mixed
     */
    public function actionBookDetails(int $detailGalleryArticleId)
    {
        $detailGalleryArticle = DetailGalleryArticle::find()->andWhere(['id' => $detailGalleryArticleId])->one();

        return $this->render('book-details', [
            'detailGalleryArticle' => $detailGalleryArticle,
        ]);
    }

}
