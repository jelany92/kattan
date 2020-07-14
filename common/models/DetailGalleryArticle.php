<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "detail_gallery_article".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $main_category_id
 * @property string|null $article_name_ar
 * @property string|null $article_name_en
 * @property string|null $link_to_preview
 * @property string|null $description
 * @property string|null $type
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BookGallery[] $bookGalleries
 * @property Category $category
 * @property User $company
 */
class DetailGalleryArticle extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const DIRECTORY_SUBCATEGORY_IMAGES = 'https://kattan-shop.adam-market.store/images/book_gallery/';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detail_gallery_article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id', 'main_category_id'], 'integer'],
            [['description', 'link_to_preview'], 'string'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['article_name_ar', 'article_name_en'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 255],
            [['main_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::class, 'targetAttribute' => ['main_category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['company_id' => 'id']],
            [['book_author_name_id'], 'exist', 'skipOnError' => true, 'targetClass' => BookAuthorName::class, 'targetAttribute' => ['book_author_name_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                     => Yii::t('app', 'ID'),
            'company_id'             => Yii::t('app', 'Company ID'),
            'book_author_name_id'    => Yii::t('app', 'Book Author Name'),
            'main_category_id'       => Yii::t('app', 'Main Category'),
            'gallery_subcategory_id' => Yii::t('app', 'Subcategory'),
            'article_name_ar'        => Yii::t('app', 'Article Name Ar'),
            'article_name_en'        => Yii::t('app', 'Article Name En'),
            'link_to_preview'        => Yii::t('app', 'Link To Preview'),
            'description'            => Yii::t('app', 'Description'),
            'type'                   => Yii::t('app', 'Type'),
            'selected_date'          => Yii::t('app', 'Selected Date'),
            'created_at'             => Yii::t('app', 'Created At'),
            'updated_at'             => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[BookGalleries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookGalleries()
    {
        return $this->hasOne(BookGallery::class, ['detail_gallery_article_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMainCategory()
    {
        return $this->hasOne(MainCategory::class, ['id' => 'main_category_id']);
    }

    /**
     * Gets query for [[Subcategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategories()
    {
        return $this->hasMany(Subcategory::class, ['main_category_id' => 'id'])->via('mainCategory');
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
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGallerySaveCategory()
    {
        return $this->hasMany(GallerySaveCategory::class, ['detail_gallery_article_id' => 'id']);
    }

    /**
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookAuthorName()
    {
        return $this->hasOne(BookAuthorName::class, ['id' => 'book_author_name_id']);
    }

    /**
     * category images path
     *
     * @param string $fileName
     * @return string
     */
    public static function subcategoryImagePath(string $fileName) : string
    {
        return Url::to(self::DIRECTORY_SUBCATEGORY_IMAGES . $fileName);
    }

    /**
     * @param $modelForm
     *
     * @throws \Exception
     */
    public function saveDetailGalleryArticle($modelForm): void
    {
        $this->company_id             = Yii::$app->user->id;
        $this->main_category_id       = $modelForm->main_category_id;
        $this->article_name_ar        = $modelForm->article_name_ar;
        $this->article_name_en        = $modelForm->article_name_en;
        $this->link_to_preview        = $modelForm->link_to_preview;
        $this->description            = $modelForm->description;
        $this->type                   = $modelForm->type;
        $this->selected_date          = $modelForm->selected_date;
        $this->save();
    }
}
