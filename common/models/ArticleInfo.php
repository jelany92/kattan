<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "article_info".
 *
 * @property int            $id
 * @property int|null       $category_id
 * @property string         $article_name_ar
 * @property string|null    $article_photo
 * @property string|null    $article_unit
 * @property integer        $article_quantity
 * @property integer        $article_buy_price
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
        'KG'  => 'KG',
        'G'   => 'G',
        'L'   => 'L',
        'BOX' => 'Paket',
    ];

    public $file;


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
            [['article_buy_price'], 'double'],
            [['article_name_ar'], 'unique'],
            [['article_name_ar', 'category_id'], 'required'],
            [['created_at', 'updated_at', 'file'], 'safe'],
            [['article_name_ar', 'article_name_en'], 'trim'],
            [['article_name_ar', 'article_name_en'], 'string', 'max' => 100],
            [['article_photo'], 'string', 'max' => 255],
            [['article_unit'], 'string', 'max' => 10],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => MainCategory::class, 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

/**
 * {@inheritdoc}
 */
public function attributeLabels()
    {
        return [
            'id'                => Yii::t('app', 'ID'),
            'category_id'       => Yii::t('app', 'Category Name'),
            'article_name_ar'   => Yii::t('app', 'Article Name'),
            'article_name_en'   => Yii::t('app', 'Article Name En'),
            'article_photo'     => Yii::t('app', 'Article Photo'),
            'article_quantity'  => Yii::t('app', 'Article Quantity'),
            'article_unit'      => Yii::t('app', 'Article Unit'),
            'article_buy_price' => Yii::t('app', 'Article buy Price'),
            'file'              => Yii::t('app', 'File'),
            'created_at'        => Yii::t('app', 'Created At'),
            'updated_at'        => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(MainCategory::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[ArticlePrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePrices()
    {
        return $this->hasMany(ArticlePrice::class, ['article_info_id' => 'id']);
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
     * @return false|int|null|string
     */
    public function getMinPrice()
    {
        $priceAll = [];
        foreach ($this->articlePrices as $articlePrices)
        {
            if ($articlePrices->article_prise_per_piece != null)
            {
                $priceAll[] = $articlePrices->article_prise_per_piece;
            }
        }
        if (!empty($priceAll))
        {
            $minPrice = array_search(min(array_combine($priceAll, $priceAll)), array_combine($priceAll, $priceAll));
            return $minPrice;
        }
        return null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
  /*  public function getTranslations()
    {
        return $this->hasMany(TourLang::className(), ['tour_id' => 'id']);
    }

    public function behaviors()
    {
        return [
            'trans' => [ // name it the way you want
                'class' => TranslateableBehavior::className(),
                // in case you named your relation differently, you can setup its relation name attribute
                // 'relation' => 'translations',
                // in case you named the language column differently on your translation schema
                // 'languageField' => 'language',
                'translationAttributes' => [
                    'article_name_ar',
                ]
            ],
        ];
    }*/
}
