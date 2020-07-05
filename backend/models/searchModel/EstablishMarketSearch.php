<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EstablishMarket;

/**
 * EstablishMarketSearch represents the model behind the search form of `backend\models\EstablishMarket`.
 */
class EstablishMarketSearch extends EstablishMarket
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['reason', 'amount', 'selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = EstablishMarket::find()->andWhere(['company_id' => \Yii::$app->user->id]);

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
            'company_id' => $this->company_id,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'reason', $this->reason]);

        return $dataProvider;
    }
}
