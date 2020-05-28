<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "subcategory".
 *
 * @property int $id
 * @property int|null $main_category_id
 * @property string $subcategory_name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property MainCategory $mainCategory
 */
class Subcategory extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['main_category_id'], 'integer'],
            [['subcategory_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['subcategory_name'], 'string', 'max' => 50],
            [['subcategory_name'], 'unique'],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::class, 'targetAttribute' => ['main_category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'main_category_id' => Yii::t('app', 'Main Category ID'),
            'subcategory_name' => Yii::t('app', 'Subcategory Name'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::class, ['id' => 'main_category_id']);
    }

    /**
     * @return array
     */
    public static function getSubcategoryList() : array
    {
        return ArrayHelper::map(self::find()->all(),'id', 'subcategory_name');
    }
}
