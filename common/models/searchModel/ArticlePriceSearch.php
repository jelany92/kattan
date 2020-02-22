<?php

namespace common\models\searchModel;

use common\models\ArticlePrice;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticlePriceSearch represents the model behind the search form of `common\models\ArticlePrice`.
 */
class ArticlePriceSearch extends ArticlePrice
{
    public $articleName;
    public $article_quantity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'article_info_id'], 'integer'],
            [['article_total_prise', 'article_prise_per_piece'], 'number'],
            [['selected_date', 'created_at', 'updated_at', 'articleName', 'article_quantity'], 'safe'],
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
        $query = ArticlePrice::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id'                      => $this->id,
            'article_info_id'         => $this->article_info_id,
            'article_total_prise'     => $this->article_total_prise,
            'article_prise_per_piece' => $this->article_prise_per_piece,
            'selected_date'           => $this->selected_date,
            'created_at'              => $this->created_at,
            'updated_at'              => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
