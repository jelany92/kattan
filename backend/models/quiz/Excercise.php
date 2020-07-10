<?php

namespace backend\models\quiz;

use common\models\ArticleInfo;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "{{%excercise}}".
 *
 * @property int $id
 * @property int $main_category_exercise_id
 * @property string $question
 * @property string $answer_a
 * @property string $answer_b
 * @property string $answer_c
 * @property string $answer_d
 * @property string $correct_answer
 * @property string $created_at
 * @property string $updated_at
 *
 * @property StudentAnswers[] $studentAnswers
 */
class Excercise extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    public $answer;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_exercise';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question'], 'string'],
            [['created_at', 'updated_at', 'answer'], 'safe'],
            [['answer_a', 'answer_b', 'answer_c', 'answer_d'], 'string', 'max' => 255],
            [['correct_answer'], 'string', 'max' => 1],
            [['main_category_exercise_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategoryExercise::class, 'targetAttribute' => ['main_category_exercise_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'main_category_exercise_id' => Yii::t('app', 'main_category_exercise_id'),
            'question'                  => Yii::t('app', 'Question'),
            'answer_a'                  => Yii::t('app', 'Answer A'),
            'answer_b'                  => Yii::t('app', 'Answer B'),
            'answer_c'                  => Yii::t('app', 'Answer C'),
            'answer_d'                  => Yii::t('app', 'Answer D'),
            'correct_answer'            => Yii::t('app', 'Correct Answer'),
            'created_at'                => Yii::t('app', 'Created At'),
            'updated_at'                => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[MainCategoryExercise]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategoryExercise()
    {
        return $this->hasOne(MainCategoryExercise::class, ['id' => 'main_category_exercise_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStudentAnswers() : ActiveQuery
    {
        return $this->hasMany(StudentAnswers::class, ['excercise_id' => 'id']);
    }

    /**
     * @return array
     */
    public function getCorrectAnswers() : array
    {
        return [
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
        ];
    }
}
