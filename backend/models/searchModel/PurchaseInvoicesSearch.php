<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\PurchaseInvoices;

/**
 * PurchaseInvoicesSearch represents the model behind the search form of `backend\models\PurchaseInvoices`.
 */
class PurchaseInvoicesSearch extends PurchaseInvoices
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', ], 'integer'],
            [['invoice_name', 'invoice_description', 'invoice_photo_id', 'seller_name', 'amount', 'selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = PurchaseInvoices::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->defaultOrder = ['selected_date' => SORT_DESC];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'invoice_name', $this->invoice_name])
            ->andFilterWhere(['like', 'invoice_description', $this->invoice_description])
            ->andFilterWhere(['like', 'seller_name', $this->seller_name])
            ->andFilterWhere(['like', 'amount', $this->amount]);

        return $dataProvider;
    }
}
