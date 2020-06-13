<?php

namespace backend\models\learn;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "learn_staff".
 *
 * @property int $id
 * @property string $staff_name
 * @property string|null $description
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property LearnMaterial[] $learnMaterials
 */
class LearnStaff extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'learn_staff';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_name'], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['staff_name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'staff_name'  => Yii::t('app', 'Staff Name'),
            'description' => Yii::t('app', 'Description'),
            'created_at'  => Yii::t('app', 'Created At'),
            'updated_at'  => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[LearnMaterials]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLearnMaterials()
    {
        return $this->hasMany(LearnMaterial::class, ['learn_staff_id' => 'id']);
    }

    public static function getStaffList()
    {
        return ArrayHelper::map(self::find()->all(),'id', 'staff_name');
    }
}
