<?php

namespace backend\models\quiz;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "{{%students}}".
 *
 * @property int $id
 * @property string $token
 * @property string $name
 * @property int $correct_answer
 * @property int $wrong_answer
 * @property int $score
 * @property int $is_complete
 * @property string $created_at
 * @property string $updated_at
 */
class Students extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_students';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'required'],
            [['token'], 'unique'],
            [['is_complete'], 'default', 'value' => 0],
            [['correct_answer', 'wrong_answer', 'score', 'is_complete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['token', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'token'          => Yii::t('app', 'Token'),
            'name'           => Yii::t('app', 'Name'),
            'correct_answer' => Yii::t('app', 'Correct Answer'),
            'wrong_answer'   => Yii::t('app', 'Wrong Answer'),
            'score'          => Yii::t('app', 'Score'),
            'is_complete'    => Yii::t('app', 'Is Complete'),
            'created_at'     => Yii::t('app', 'Created At'),
            'updated_at'     => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * save record student
     */
    public function saveStudent()
    {
        $this->getToken();
        if ($this->validate())
        {
            $this->is_complete = 0;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * generate token
     */
    public function getToken()
    {
        if ($this->isNewRecord)
        {
            $this->token = Yii::$app->getSecurity()->generateRandomString(10);
        }
    }

    /**
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function sumCorrect()
    {
        $correctAnswer = [];
        $wrongAnswer   = [];
        $corrects = StudentAnswersCrud::find()->select('quiz_student_answers.*, e.correct_answer correct')->leftJoin(['e' => Excercise::tableName()], ['e.id' => new Expression('quiz_student_answers.excercise_id')])->where(['quiz_student_answers.student_id' => $this->id])->asArray()->all();

        foreach ($corrects as $correct)
        {
            if ($correct['student_answer'] == $correct['correct'])
            {
                $correctAnswer[] = $correct['excercise_id'];
            }
            else
            {
                $wrongAnswer[] = $correct['excercise_id'];
            }
        }
        $this->is_complete    = true;
        $this->wrong_answer   = count($wrongAnswer);
        $this->correct_answer = count($correctAnswer);
        $this->score          = count($correctAnswer);
        $this->update(false);
    }
}
