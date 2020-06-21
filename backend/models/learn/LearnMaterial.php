<?php

namespace backend\models\learn;

use Yii;

/**
 * This is the model class for table "learn_material".
 *
 * @property int $id
 * @property int|null $learn_staff_id
 * @property string $material_name
 * @property string $material_link
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property LearnStaff $learnStaff
 */
class LearnMaterial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'learn_material';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['learn_staff_id'], 'integer'],
            [['material_name', 'material_link'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['material_name'], 'string', 'max' => 100],
            [['material_link'], 'string', 'max' => 255],
            [['learn_staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => LearnStaff::class, 'targetAttribute' => ['learn_staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'learn_staff_id' => Yii::t('app', 'Staff Name'),
            'material_name'  => Yii::t('app', 'Material Name'),
            'material_link'  => Yii::t('app', 'Material Link'),
            'created_at'     => Yii::t('app', 'Created At'),
            'updated_at'     => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[LearnStaff]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLearnStaff()
    {
        return $this->hasOne(LearnStaff::class, ['id' => 'learn_staff_id']);
    }

}
