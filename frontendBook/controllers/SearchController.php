<?php

namespace frontendBook\controllers;

use common\models\DetailGalleryArticle;
use common\models\UserModel;
use yii\data\ActiveDataProvider;
use yii\web\Controller;

class SearchController extends Controller
{
    /**
     * @param string $search
     *
     * @return string
     */
    public function actionGlobalSearch(string $search)
    {
        $articleInfo  = DetailGalleryArticle::find()->andWhere([
                                                                   'and',
                                                                   [
                                                                       'like',
                                                                       'article_name_ar',
                                                                       $search,
                                                                   ],
                                                                   ['company_id' => UserModel::JELANY_BOOK_CATEGORY],
                                                               ]);
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $articleInfo,
                                               ]);
        return $this->render('global-search', ['dataProvider' => $dataProvider,]);
    }

}
