<?php

namespace backend\models\quiz;

use Yii;
use yii\base\Model;

/**
 * This is the model class for table "{{%student_answers}}".
 *
 * @property int $id
 * @property int $excercise_id
 * @property int $student_id
 * @property string $student_answer
 * @property array $question
 * @property array $answer
 *
 * @property Excercise $excercise
 * @property Students $student
 */
class QuizAnswerForm extends Model
{
    public $question;
    public $answer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['student_answer'], 'required', 'message' => Yii::t('app', 'Answer cannot be blank.')],
           //[['answer'], 'required'],
            [['question', 'answer'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question' => Yii::t('app', 'Question'),
            'answer'   => Yii::t('app', 'Answer'),
        ];
    }

}
