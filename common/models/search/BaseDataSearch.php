<?php

namespace common\models\search;

use common\models\BaseData;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * BaseDataSearch represents the model behind the search form of `common\models\BaseData`.
 */
class BaseDataSearch extends BaseData
{
    public $companyType = '';
    public $conditionId = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'country_id', 'application_trainee_count', 'application_dual_students_count', 'application_executives_count', 'admin_count', 'employee_count', 'location_count', 'company_count'], 'integer'],
            [['code', 'company_name', 'conditionId', 'companyType', 'street', 'house_number', 'zip_code', 'city', 'salutation', 'first_name', 'last_name', 'base_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = BaseData::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
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
            'country_id' => $this->country_id,
            'base_date' => $this->base_date,
            'application_trainee_count' => $this->application_trainee_count,
            'application_dual_students_count' => $this->application_dual_students_count,
            'application_executives_count' => $this->application_executives_count,
            'admin_count' => $this->admin_count,
            'employee_count' => $this->employee_count,
            'location_count' => $this->location_count,
            'company_count' => $this->company_count,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if( 0 < $this->companyType){
            $query->alias('base_data');
            $query->andFilterWhere(['company_type_id' => $this->companyType]);
        }
        elseif ($this->companyType == 0)
        {
            $query->all();
        }
        if( 0 < $this->conditionId){
            $query->innerJoinWith('baseDataConditions');
            $query->andFilterWhere(['condition_id' => $this->conditionId]);
        }

        $query->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'street', $this->street])
            ->andFilterWhere(['like', 'house_number', $this->house_number])
            ->andFilterWhere(['like', 'zip_code', $this->zip_code])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'salutation', $this->salutation])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }
}
