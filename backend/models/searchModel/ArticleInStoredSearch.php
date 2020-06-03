<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\ArticleInStored;

/**
 * ArticleInStoredSearch represents the model behind the search form of `backend\models\ArticleInStored`.
 */
class ArticleInStoredSearch extends ArticleInStored
{
    public $articleName;
    public $article_quantity;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'article_info_id', 'count'], 'integer'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['articleName', 'article_quantity'], 'safe'],
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
     * @param int $articleInventoryId
     *
     * @return ActiveDataProvider
     */
    public function search($params, int $articleInventoryId)
    {
        $query = ArticleInStored::find()->innerJoinWith('articleInfo')->andWhere(['company_id' => \Yii::$app->user->id, 'article_inventory_id' => $articleInventoryId]);

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
            'article_info_id' => $this->article_info_id,
            'count' => $this->count,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
