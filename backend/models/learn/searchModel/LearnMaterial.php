<?php

namespace backend\models\learn\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\learn\LearnMaterial as LearnMaterialModel;

/**
 * LearnMaterial represents the model behind the search form of `backend\models\learn\LearnMaterial`.
 */
class LearnMaterial extends LearnMaterialModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'learn_staff_id'], 'integer'],
            [['material_name', 'material_link', 'created_at', 'updated_at'], 'safe'],
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
        $query = LearnMaterialModel::find();

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
            'learn_staff_id' => $this->learn_staff_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'material_name', $this->material_name])
            ->andFilterWhere(['like', 'material_link', $this->material_link]);

        return $dataProvider;
    }
}
