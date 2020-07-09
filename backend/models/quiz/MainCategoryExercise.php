<?php

namespace backend\models\quiz;

use common\models\query\traits\TimestampBehaviorTrait;

/**
 * This is the model class for table "quiz_main_category_exercise".
 *
 * @property int $id
 * @property string $main_category_exercise_name
 * @property string|null $description
 * @property string|null $question_type
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Excercise[] $quizExercises
 */
class MainCategoryExercise extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quiz_main_category_exercise';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_category_exercise_name'], 'required'],
            [['description', 'question_type'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['main_category_exercise_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'main_category_exercise_name' => 'Main Category Exercise Name',
            'description' => 'Description',
            'question_type' => 'Question Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[QuizExercises]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getQuizExercises()
    {
        return $this->hasMany(Excercise::class, ['main_category_exercise_id' => 'id']);
    }
}
