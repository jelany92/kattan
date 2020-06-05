<?php

namespace backend\models;

use common\models\ArticleInfo;
use common\models\ArticlePrice;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "article_in_stored".
 *
 * @property int $id
 * @property int|null $article_info_id
 * @property int|null $article_inventory_id
 * @property int|null $count
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticleInfo $articleInfo
 */
class ArticleInStored extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_in_stored';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_info_id', 'article_inventory_id', 'count'], 'integer'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['article_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleInfo::class, 'targetAttribute' => ['article_info_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'article_info_id'      => Yii::t('app', 'Article Info ID'),
            'article_inventory_id' => Yii::t('app', 'Article Inventory ID'),
            'inventory_name'       => Yii::t('app', 'Inventory Name'),
            'count'                => Yii::t('app', 'Count'),
            'selected_date'        => Yii::t('app', 'Selected Date'),
            'created_at'           => Yii::t('app', 'Created At'),
            'updated_at'           => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInfo()
    {
        return $this->hasOne(ArticleInfo::class, ['id' => 'article_info_id']);
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePrice()
    {
        return $this->hasOne(ArticlePrice::class, ['article_info_id' => 'article_info_id']);
    }

    /**
     * Gets query for [[ArticleInStoreds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInventory()
    {
        return $this->hasOne(ArticleInventory::class, ['id' => 'article_inventory_id']);
    }

    /**
     * {@inheritdoc}
     * @return \backend\models\query\ArticleInStoredQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \backend\models\query\ArticleInStoredQuery(get_called_class());
    }
}
