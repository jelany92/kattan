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
        $articleInfo  = ArticleInfo::find()->andWhere([
                                                          'and',
                                                          [
                                                              'like',
                                                              'article_name_ar',
                                                              $search,
                                                          ],
                                                          ['company_id' => \Yii::$app->user->id],
                                                      ]);
        $dataProvider = new ActiveDataProvider([
                                                   'query' => $articleInfo,
                                               ]);
        return $this->render('global-search', ['dataProvider' => $dataProvider,]);
    }

}
