<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property int|null $category_id
 * @property string $article_name
 * @property string|null $article_photo
 * @property int|null $article_count
 * @property string|null $article_unit
 * @property float|null $article_total_prise
 * @property float|null $article_prise_per_piece
 * @property string|null $status
 * @property string|null $seller_name
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Category $category
 */
class Article extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const UNIT_LIST =
        [
            'KG' => 'KG',
            'G' => 'G',
            'L' => 'L',
        ];

    const STATUS = [
        'BUY'  => 'Einkaufen',
        'SALE' => 'Verkaufen',
    ] ;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'article_count'], 'integer'],
            [['article_name'], 'required'],
            [['article_total_prise', 'article_prise_per_piece'], 'double'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['article_name', 'seller_name'], 'string', 'max' => 100],
            [['article_photo'], 'string', 'max' => 255],
            [['article_unit'], 'string', 'max' => 25],
            [['status'], 'string', 'max' => 50],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'article_name' => Yii::t('app', 'Article Name'),
            'article_photo' => Yii::t('app', 'Article Photo'),
            'article_count' => Yii::t('app', 'Article Count'),
            'article_unit' => Yii::t('app', 'Article Unit'),
            'article_total_prise' => Yii::t('app', 'Article Total Prise'),
            'article_prise_per_piece' => Yii::t('app', 'Article Prise Per Piece'),
            'status' => Yii::t('app', 'Status'),
            'seller_name' => Yii::t('app', 'Seller Name'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

}
