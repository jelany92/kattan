<?php

namespace common\models\search;

use common\models\CategoryFunction;
use common\models\Component;
use common\models\FunctionCompanyType;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * ComponentSearch represents the model behind the search form of `common\models\Component`.
 */
class ComponentSearch extends Component
{
    public $category_id      = '';
    public $companyType      = '';
    public $textSearch       = '';
    public $conditionId      = '';
    public $jobquickModuleId = '';

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'conditionId', 'jobquickModuleId'], 'integer'],
            [['name', 'description_short', 'description_long', 'companyType', 'textSearch'], 'safe'],
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
    public function search($params = null)
    {
        $query = Component::find();

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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if(0 < strlen(trim($this->textSearch))){

            $query->andFilterWhere(['or',
                ['like', 'description_short', $this->textSearch],
                ['like', 'description_long', $this->textSearch],
                ['like', 'name', $this->textSearch],
                ]);
        }else{
            $query->andFilterWhere(['like', 'description_short', $this->description_short])
                ->andFilterWhere(['like', 'description_long', $this->description_long]);
        }

        $query->andFilterWhere(['like', 'name', $this->name]);


        if( 0 < $this->category_id){
            $query->alias('function');
            $query->innerJoin(CategoryFunction::tableName() .' AS categoryFunction', 'categoryFunction.function_id = function.id' );
            $query->andFilterWhere(['categoryFunction.category_id' => $this->category_id]);

        }
        elseif ($this->category_id < 0)
        {
            $query->andFilterWhere(['not', ['in', 'id', ArrayHelper::map(CategoryFunction::find()->select('function_id')->distinct()->all(), 'function_id', 'function_id')]]);
        }

        if( 0 < $this->conditionId){
            $query->innerJoinWith('functionConditions');
            $query->andFilterWhere(['condition_id' => $this->conditionId]);
        }

        if( 0 < $this->jobquickModuleId){
            $query->innerJoinWith('functionJobquickModules');
            $query->andFilterWhere(['jobquick_module_id' => $this->jobquickModuleId]);
        }

        if( 0 < $this->companyType){
            $query->alias('function');
            $query->innerJoin(FunctionCompanyType::tableName() .' AS functionCompanyType', 'functionCompanyType.function_id = function.id ' );
            $query->andFilterWhere(['functionCompanyType.company_type_id' => $this->companyType]);
        }
        elseif ($this->companyType == 0)
        {
            $query->all();
        }

        return $dataProvider;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(),[
            'textSearch' => Yii::t('app', 'Volltextsuche'),
        ]);
    }
}
