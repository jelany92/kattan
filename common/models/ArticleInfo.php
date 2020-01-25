<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "article_info".
 *
 * @property int            $id
 * @property int|null       $category_id
 * @property string         $article_name
 * @property string|null    $article_photo
 * @property string|null    $article_unit
 * @property integer        $article_quantity
 * @property string|null    $created_at
 * @property string|null    $updated_at
 *
 * @property Category       $category
 * @property ArticlePrice[] $articlePrices
 */
class ArticleInfo extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const UNIT_LIST = [
        'KG' => 'KG',
        'G'  => 'G',
        'L'  => 'L',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'article_quantity'], 'integer'],
            [['article_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['article_name'], 'string', 'max' => 100],
            [['article_photo'], 'string', 'max' => 255],
            [['article_unit'], 'string', 'max' => 10],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

/**
 * {@inheritdoc}
 */
public function attributeLabels()
    {
        return [
            'id'               => Yii::t('app', 'ID'),
            'category_id'      => Yii::t('app', 'Category ID'),
            'article_name'     => Yii::t('app', 'Article Name'),
            'article_photo'    => Yii::t('app', 'Article Photo'),
            'article_quantity' => Yii::t('app', 'Article Quantity'),
            'article_unit'     => Yii::t('app', 'Article Unit'),
            'created_at'       => Yii::t('app', 'Created At'),
            'updated_at'       => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ArticlePrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePrices()
    {
        return $this->hasMany(ArticlePrice::className(), ['article_info_id' => 'id']);
    }
}
