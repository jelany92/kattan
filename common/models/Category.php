<?php

namespace common\models;

use common\models\query\CategoryQuery;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property int $company_id
 * @property string $category_name
 * @property string $category_photo
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticleInfo[] $articles
 */
class Category extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_name'], 'trim'],
            [['category_name'], 'required'],
            [['company_id'], 'integer'],
            [['created_at', 'updated_at', 'file'], 'safe'],
            [['category_name'], 'string', 'max' => 50],
            [['category_name'], 'unique'],
            [['category_photo'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'category_name'  => Yii::t('app', 'Category Name'),
            'category_photo' => Yii::t('app', 'Category Photo'),
            'created_at'     => Yii::t('app', 'Created At'),
            'updated_at'     => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(ArticleInfo::class, ['category_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserModel::class, ['id' => 'company_id']);
    }

    /**
     * @return array
     */
    public static function getCategoryList() : array
    {
        return ArrayHelper::map(Category::find()->andWhere(['company_id' => Yii::$app->user->id])->all(),'id', 'category_name');
    }

    /**
     * @return mixed|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new CategoryQuery(get_called_class());
    }
}
