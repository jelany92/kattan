<?php

namespace backend\controllers;

use common\models\ArticleInfo;
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
        $articleInfo = ArticleInfo::find()->andWhere(['like','article_name_ar', $search]);
        $dataProvider = new ActiveDataProvider([
            'query' => $articleInfo,
        ]);
        return $this->render('global-search', ['dataProvider' => $dataProvider,]);
    }

}
