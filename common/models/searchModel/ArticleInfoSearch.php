<?php

namespace common\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ArticleInfo;

/**
 * ArticleInfoSearch represents the model behind the search form of `common\models\ArticleInfo`.
 */
class ArticleInfoSearch extends ArticleInfo
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
            [['article_name_ar', 'article_photo', 'article_unit', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ArticleInfo::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'article_name_ar', $this->article_name_ar])
            ->andFilterWhere(['like', 'article_photo', $this->article_photo])
            ->andFilterWhere(['like', 'article_unit', $this->article_unit]);
        return $dataProvider;
    }
}
