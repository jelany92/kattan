<?php

namespace backend\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TaxOffice;

/**
 * TaxOfficeSearch represents the model behind the search form of `backend\models\TaxOffice`.
 */
class TaxOfficeSearch extends TaxOffice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['income'], 'integer'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = TaxOffice::find()->andWhere(['company_id' => \Yii::$app->user->id]);
        
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
                                   'id'            => $this->id,
                                   'income'        => $this->income,
                                   'selected_date' => $this->selected_date,
                                   'created_at'    => $this->created_at,
                                   'updated_at'    => $this->updated_at,
                               ]);

        return $dataProvider;
    }
}
