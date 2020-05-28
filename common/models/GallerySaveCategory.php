<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery_save_category".
 *
 * @property int $id
 * @property int|null $detail_gallery_article_id
 * @property int|null $subcategory_id
 *
 * @property MainCategory $mainCategory
 * @property Subcategory $subcategory
 */
class GallerySaveCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'gallery_save_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail_gallery_article_id', 'subcategory_id'], 'integer'],
            [['detail_gallery_article_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetailGalleryArticle::class, 'targetAttribute' => ['detail_gallery_article_id' => 'id']],
            [['subcategory_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subcategory::class, 'targetAttribute' => ['subcategory_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'detail_gallery_article_id' => Yii::t('app', 'detail_gallery_article_id'),
            'subcategory_id'            => Yii::t('app', 'Subcategory ID'),
        ];
    }

    /**
     * Gets query for [[MainCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetailGalleryArticle()
    {
        return $this->hasOne(DetailGalleryArticle::class, ['id' => 'detail_gallery_article_id']);
    }

    /**
     * Gets query for [[Subcategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubcategory()
    {
        return $this->hasOne(Subcategory::class, ['id' => 'subcategory_id']);
    }
}
