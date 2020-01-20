<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "article_price".
 *
 * @property int $id
 * @property int|null $article_info_id
 * @property int|null $article_count
 * @property float|null $article_total_prise
 * @property float|null $article_prise_per_piece
 * @property string|null $seller_name
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticleInfo $articleInfo
 * @property Category $category
 */
class ArticlePrice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_price';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['article_info_id', 'article_count'], 'integer'],
            [['article_total_prise', 'article_prise_per_piece'], 'number'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['seller_name'], 'string', 'max' => 100],
            [['article_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleInfo::className(), 'targetAttribute' => ['article_info_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'article_info_id' => Yii::t('app', 'Article Info ID'),
            'article_count' => Yii::t('app', 'Article Count'),
            'article_total_prise' => Yii::t('app', 'Article Total Prise'),
            'article_prise_per_piece' => Yii::t('app', 'Article Prise Per Piece'),
            'seller_name' => Yii::t('app', 'Seller Name'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInfo()
    {
        return $this->hasOne(ArticleInfo::className(), ['id' => 'article_info_id']);
    }

}
