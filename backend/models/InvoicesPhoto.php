<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "purchase_invoices".
 *
 * @property int $id
 * @property string $invoice_name
 * @property string $invoice_description
 * @property int|null $invoice_photo_id
 * @property string $seller_name
 * @property float $amount
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticlePrice[] $articlePrices
 * @property InvoicesPhoto $invoicePhoto
 */
class InvoicesPhoto extends \yii\db\ActiveRecord
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
            [['invoice_name', 'invoice_description', 'seller_name', 'amount'], 'required'],
            [['invoice_photo_id'], 'integer'],
            [['amount'], 'number'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['invoice_name', 'seller_name'], 'string', 'max' => 100],
            [['invoice_description'], 'string', 'max' => 255],
            [['invoice_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvoicesPhoto::className(), 'targetAttribute' => ['invoice_photo_id' => 'id']],
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
            'invoice_photo_id' => Yii::t('app', 'Invoice Photo ID'),
            'seller_name' => Yii::t('app', 'Seller Name'),
            'amount' => Yii::t('app', 'Amount'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ArticlePrices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticlePrices()
    {
        return $this->hasMany(ArticlePrice::className(), ['purchase_invoices_id' => 'id']);
    }

    /**
     * Gets query for [[InvoicePhoto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoicePhoto()
    {
        return $this->hasOne(InvoicesPhoto::className(), ['id' => 'invoice_photo_id']);
    }
}
