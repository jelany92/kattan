<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "detail_gallery_article".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int|null $category_id
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
            [['company_id', 'category_id'], 'integer'],
            [['description', 'link_to_preview'], 'string'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['article_name_ar', 'article_name_en'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'company_id'      => Yii::t('app', 'Company ID'),
            'category_id'     => Yii::t('app', 'Category ID'),
            'article_name_ar' => Yii::t('app', 'Article Name Ar'),
            'article_name_en' => Yii::t('app', 'Article Name En'),
            'link_to_preview' => Yii::t('app', 'Link To Preview'),
            'description'     => Yii::t('app', 'Description'),
            'type'            => Yii::t('app', 'Type'),
            'selected_date'   => Yii::t('app', 'Selected Date'),
            'created_at'      => Yii::t('app', 'Created At'),
            'updated_at'      => Yii::t('app', 'Updated At'),
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
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
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
     * @param $modelForm
     *
     * @throws \Exception
     */
    public function saveDetailGalleryArticle($modelForm) : void
    {
        $this->company_id      = Yii::$app->user->id;
        $this->category_id     = $modelForm->company_id;
        $this->article_name_ar = $modelForm->article_name_ar;
        $this->article_name_en = $modelForm->article_name_en;
        $this->link_to_preview = $modelForm->link_to_preview;
        $this->description     = $modelForm->description;
        $this->type            = $modelForm->type;
        $this->selected_date   = $modelForm->selected_date;
        $this->save();
    }
}
