<?php

namespace common\models\searchModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DetailGalleryArticle;

/**
 * DetailGalleryArticlelSearch represents the model behind the search form of `common\models\DetailGalleryArticle`.
 */
class DetailGalleryArticlelSearch extends DetailGalleryArticle
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id', 'category_id', 'link_to_preview'], 'integer'],
            [['article_name_ar', 'article_name_en', 'description', 'type', 'selected_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = DetailGalleryArticle::find()->andWhere(['company_id' => \Yii::$app->user->id]);

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
            'category_id' => $this->category_id,
            'link_to_preview' => $this->link_to_preview,
            'selected_date' => $this->selected_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'article_name_ar', $this->article_name_ar])
            ->andFilterWhere(['like', 'article_name_en', $this->article_name_en])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}