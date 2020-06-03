<?php

namespace backend\models\searchModel;

use backend\models\ArticleInventory;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ArticleInStoredSearch represents the model behind the search form of `backend\models\ArticleInStored`.
 */
class ArticleInventorySearch extends ArticleInventory
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_name'], 'safe'],
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
        $query = ArticleInventory::find();

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
            'inventory_name' => $this->inventory_name,
        ]);

        return $dataProvider;
    }
}
