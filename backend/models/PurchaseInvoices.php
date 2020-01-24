<?php

namespace backend\models;

use common\models\ArticlePrice;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;

/**
 * This is the model class for table "purchase_invoices".
 *
 * @property int $id
 * @property string $invoice_name
 * @property string $invoice_description
 * @property string|null $invoicePhoto
 * @property string $seller_name
 * @property float $amount
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticlePrice[] $articlePrices
 */
class PurchaseInvoices extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const PREFIX_THUMBNAIL                 = 'prefixThumbnail';
    const PREFIX_ORIGINAL                  = 'prefixOriginal';

    public $invoicePhoto;
    public $logoFile;

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
            [['amount'], 'number'],
            [['invoice_photo_id'], 'integer'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['invoice_name', 'seller_name'], 'string', 'max' => 100],
            [['invoice_description'], 'string', 'max' => 255],
            [['logoFile', 'invoicePhoto'], 'file', 'extensions' => ['jpg', 'jpeg', 'gif', 'png']],
            [['logoFile', 'invoicePhoto'], 'file', 'maxSize' => 5000000],
            [['invoice_photo_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvoicesPhoto::class, 'targetAttribute' => ['invoice_photo_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                  => Yii::t('app', 'ID'),
            'invoice_name'        => Yii::t('app', 'Invoice Name'),
            'invoice_description' => Yii::t('app', 'Invoice Description'),
            'invoice_photo_id'       => Yii::t('app', 'Invoice Photo'),
            'invoicePhoto'       => Yii::t('app', 'Photo'),
            'seller_name'         => Yii::t('app', 'Seller Name'),
            'amount'              => Yii::t('app', 'Amount'),
            'selected_date'       => Yii::t('app', 'Selected Date'),
            'created_at'          => Yii::t('app', 'Created At'),
            'updated_at'          => Yii::t('app', 'Updated At'),
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

    /**
     * uploads logo image file to upload directory as specified in backend/config/params.php
     * generates random file name and saves original with this name in upload folder
     * creates thumbnail file for original image
     *
     * @throws \yii\base\Exception
     */
    public function logoUpload()
    {
        $uploadedFile = UploadedFile::getInstance($this, 'invoice_photo');

        if ($uploadedFile instanceof UploadedFile)
        {
            $mangeledFileName     = Yii::$app->security->generateRandomString() . '.' . $uploadedFile->extension;
            $originalFileMangeled = $this->generateFilename(self::PREFIX_ORIGINAL, $mangeledFileName);
            $uploadedFile->saveAs($originalFileMangeled);
            // generate a thumbnail file
            $thumbnailFileM = $this->generateFilename(self::PREFIX_THUMBNAIL, $mangeledFileName);
            Image::thumbnail($originalFileMangeled, Yii::$app->params['thumbnailWidth'], Yii::$app->params['thumbnailHeight'])
                ->save(Yii::getAlias($thumbnailFileM));
            $this->invoice_photo = $mangeledFileName;
        }
    }

    /**
     * Generates the filename
     *
     * @param $prefix
     * @param $fileName
     *
     * @return string
     */
    private function generateFilename($prefix, $fileName)
    {
        $originalFilename = Yii::$app->params[$prefix] . $fileName;
        $file             = Yii::$app->params['uploadDirectory'] . DIRECTORY_SEPARATOR . $originalFilename;
        return $file;
    }

    /**
     * creates Url for the thumbnail file
     *
     * @return string the created URL
     */
    public function getLogoThumbnailUrl()
    {
        if (0 < strlen($this->invoicePhoto))
        {
            return Yii::$app->urlManager->createUrl($this->generateFilename(self::PREFIX_THUMBNAIL, $this->invoicePhoto));
        }
        return false;
    }
}
