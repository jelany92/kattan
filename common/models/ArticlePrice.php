<?php

namespace common\models;

use backend\models\PurchaseInvoices;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

/**
 * This is the model class for table "article_price".
 *
 * @property int $id
 * @property int|null $article_info_id
 * @property int|null $purchase_invoices_id
 * @property int|null $article_count
 * @property float|null $article_total_prise
 * @property float|null $article_prise_per_piece
 * @property string|null $status
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticleInfo $articleInfo
 * @property PurchaseInvoices $purchaseInvoices
 */
class ArticlePrice extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const STATUS = [
        'BUY'  => 'Einkaufen',
        'SALE' => 'Verkaufen',
    ];

    public $articleName;
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
            [['article_info_id', 'purchase_invoices_id', 'article_count'], 'integer'],
            [['article_total_prise', 'article_prise_per_piece'], 'number'],
            [['selected_date', 'created_at', 'updated_at', 'articleName'], 'safe'],
            [['status'], 'string', 'max' => 50],
            [['article_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleInfo::class, 'targetAttribute' => ['article_info_id' => 'id']],
            [['purchase_invoices_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseInvoices::class, 'targetAttribute' => ['purchase_invoices_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                      => Yii::t('app', 'ID'),
            'article_info_id'         => Yii::t('app', 'Article Info ID'),
            'articleName'             => Yii::t('app', 'Article Name'),
            'purchase_invoices_id'    => Yii::t('app', 'Purchase Invoices ID'),
            'article_count'           => Yii::t('app', 'Article Count'),
            'article_total_prise'     => Yii::t('app', 'Article Total Prise'),
            'article_prise_per_piece' => Yii::t('app', 'Article Prise Per Piece'),
            'status'                  => Yii::t('app', 'Status'),
            'selected_date'           => Yii::t('app', 'Selected Date'),
            'created_at'              => Yii::t('app', 'Created At'),
            'updated_at'              => Yii::t('app', 'Updated At'),
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
     * Gets query for [[PurchaseInvoices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPurchaseInvoices()
    {
        return $this->hasOne(PurchaseInvoices::class, ['id' => 'purchase_invoices_id']);
    }
}