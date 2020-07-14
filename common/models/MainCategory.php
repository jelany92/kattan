<?php

namespace common\models;

use common\models\query\MainCategoryQuery;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * This is the model class for table "main_category".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $category_name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $company
 * @property Subcategory[] $subcategories
 */
class MainCategory extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const DIRECTORY_MAIN_CATEGORY_IMAGES = 'https://kattan-shop.adam-market.store/images/category/';

    public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'main_category';
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
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(User::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Subcategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::class, ['main_category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(ArticleInfo::class, ['category_id' => 'id']);
    }

    /**
     * category images path
     *
     * @param string $fileName
     * @return string
     */
    public static function mainCategoryImagePath(string $fileName) : string
    {
        return Url::to(self::DIRECTORY_MAIN_CATEGORY_IMAGES . $fileName);
    }

    /**
     * @param int|null $companyId
     *
     * @return array
     */
    public static function getMainCategoryList(int $companyId = null) : array
    {
        if ($companyId == null)
        {
            $companyId = UserModel::JELANY_BOOK_CATEGORY;
        }
        return ArrayHelper::map(self::find()->andWhere(['company_id' => $companyId])->all(),'id', 'category_name');
    }

    /**
     * @return mixed|\yii\db\ActiveQuery
     */
    public static function find()
    {
        return new MainCategoryQuery(get_called_class());
    }
}
