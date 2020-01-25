<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Article;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ArticleSearch extends Article
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'article_count', 'article_total_prise', 'article_prise_per_piece', 'seller_name'], 'integer'],
            [['article_name', 'article_photo', 'article_unit', 'status', 'selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = Article::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'article_count' => $this->article_count,
            'article_total_prise' => $this->article_total_prise,
            'article_prise_per_piece' => $this->article_prise_per_piece,
            'seller_name' => $this->seller_name,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'article_name', $this->article_name])
            ->andFilterWhere(['like', 'article_photo', $this->article_photo])
            ->andFilterWhere(['like', 'article_unit', $this->article_unit])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}