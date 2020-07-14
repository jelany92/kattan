<?php

namespace backend\models\quiz;

use common\models\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "{{%student_answers}}".
 *
 * @property int $id
 * @property int $excercise_id
 * @property int $student_id
 * @property string $student_answer
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Excercise $excercise
 * @property Students $student
 */
class StudentAnswers extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quiz_student_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['excercise_id', 'student_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['student_answer'], 'string', 'max' => 10],
            [['excercise_id'], 'exist', 'skipOnError' => true, 'targetClass' => Excercise::class, 'targetAttribute' => ['excercise_id' => 'id']],
            [['student_id'], 'exist', 'skipOnError' => true, 'targetClass' => Students::class, 'targetAttribute' => ['student_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'excercise_id'   => Yii::t('app', 'Question'),
            'student_id'     => Yii::t('app', 'Student Name'),
            'student_answer' => Yii::t('app', 'Your Answer'),
            'created_at'     => Yii::t('app', 'Created At'),
            'updated_at'     => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExcercise()
    {
        return $this->hasOne(Excercise::class, ['id' => 'excercise_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStudent()
    {
        return $this->hasOne(Students::class, ['id' => 'student_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnswerName($connectionTable, $value)
    {
        self::find()->innerJoinWith('student')->andWhere(['']);
        return $this->hasOne(Students::class, ['id' => 'student_id']);
    }



}
