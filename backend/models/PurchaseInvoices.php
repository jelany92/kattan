<?php

namespace backend\models;

use common\models\ArticlePrice;
use Yii;

/**
 * This is the model class for table "purchase_invoices".
 *
 * @property int $id
 * @property int|null $article_price_id
 * @property string $invoice_name
 * @property string $invoice_description
 * @property string|null $invoice_photo
 * @property string $seller_name
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticlePrice $articlePrice
 */
class PurchaseInvoices extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchase_invoices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_name', 'invoice_description', 'seller_name'], 'required'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['invoice_name', 'seller_name'], 'string', 'max' => 100],
            [['invoice_description', 'invoice_photo'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'invoice_name' => Yii::t('app', 'Invoice Name'),
            'invoice_description' => Yii::t('app', 'Invoice Description'),
            'invoice_photo' => Yii::t('app', 'Invoice Photo'),
            'seller_name' => Yii::t('app', 'Seller Name'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ArticlePrice]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePrice()
    {
        return $this->hasOne(ArticlePrice::className(), ['id' => 'article_price_id']);
    }
}
