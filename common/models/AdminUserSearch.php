<?php

namespace common\models\search;

use common\models\AdminUser;
use common\models\auth\AuthAssignment;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdminUserSearch represents the model behind the search form of `common\models\AdminUser`.
 */
class AdminUserSearch extends AdminUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'first_name', 'last_name', 'password', 'password_reset_token', 'email', 'active_from', 'active_until', 'role', 'created_at', 'updated_at'], 'safe'],
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
        $query = AdminUser::find()->joinWith('itemNames');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->sort->attributes['role'] = [
            'asc'  => [AuthAssignment::tableName().'.item_name' => SORT_ASC],
            'desc' => [AuthAssignment::tableName().'.item_name' => SORT_DESC],
        ];


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'active_from' => $this->active_from,
            'active_until' => $this->active_until,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'item_name' => $this->role,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
