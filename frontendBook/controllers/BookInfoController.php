<?php

namespace frontendBook\controllers;

use backend\models\searchModel\MainCategorySearch;
use common\models\MainCategory;
use common\models\searchModel\BookAuthorNameSearch;
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
     * @return mixed
     */
    public function actionMainCategory()
    {
        $mainCategories = MainCategory::find()->andWhere(['company_id' => 2])->all();

        return $this->render('main-category', [
            'mainCategories' => $mainCategories,
        ]);
    }

}
