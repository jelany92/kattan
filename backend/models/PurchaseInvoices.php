<?php

namespace backend\models;

use common\models\ArticlePrice;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "purchase_invoices".
 *
 * @property int $id
 * @property string $invoice_name
 * @property string $invoice_description
 * @property array $invoiceFileList
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

    public $writtenFiles = [];
    public $file;

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
            [['amount'], 'double'],
            [['selected_date', 'created_at', 'updated_at', 'invoiceFileList', 'file'], 'safe'],
            [['invoice_name', 'seller_name'], 'string', 'max' => 100],
            [['invoice_description'], 'string', 'max' => 255],
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
            'file'                => Yii::t('app', 'Photo'),
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
        return $this->hasMany(ArticlePrice::class, ['purchase_invoices_id' => 'id']);
    }

    /**
     * Gets query for [[InvoicePhoto]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInvoicePhotos()
    {
        return $this->hasMany(InvoicesPhoto::class, ['purchase_invoices_id' => 'id']);
    }

    /**
     * $id
     * @return bool
     * @throws \yii\base\Exception
     */
    protected function upload($id)
    {
        if ($this->validate())
        {
            foreach ($this->file as $file)
            {
                $randomNameString  = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $this->writtenFiles[] = [
                    'fileName'         => $id . '_' . $randomNameString,
                    'fileExtension'    => $file->extension,
                    'originalFileName' => $file->baseName. '.' . $file->extension,
                ];
                $fileName          = $randomNameString;
                $filePath          = Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail']  . DIRECTORY_SEPARATOR . $id . '_' . $fileName;
                $file->saveAs($filePath);
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function saveInvoicesPhoto()
    {
        $this->file = UploadedFile::getInstances($this, 'file');
        if ($this->file != null)
        {
            if ($this->upload($this->id))
            {
                foreach ($this->writtenFiles as $arrFileData)
                {
                    $modelInvoicesPhoto                       = new InvoicesPhoto();
                    $modelInvoicesPhoto->purchase_invoices_id = $this->id;
                    $modelInvoicesPhoto->photo_path           = $arrFileData['fileName'];
                    if ($modelInvoicesPhoto->save() == false)
                    {
                        throw new \Exception('Rechnung File wurde nicht gespeichert');
                    }
                }
                return true;
            }
        }
    }
}
