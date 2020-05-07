<?php

namespace backend\models;

use common\models\UserModel;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "invoices_photo".
 *
 * @property int $id
 * @property int|null $purchase_invoices_id
 * @property string|null $photo_path
 *
 * @property PurchaseInvoices $purchaseInvoices
 */
class InvoicesPhoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoices_photo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['photo_path'], 'trim'],
            [['purchase_invoices_id'], 'integer'],
            [['photo_path'], 'string', 'max' => 255],
            [['purchase_invoices_id'], 'exist', 'skipOnError' => true, 'targetClass' => PurchaseInvoices::class, 'targetAttribute' => ['purchase_invoices_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'purchase_invoices_id' => Yii::t('app', 'Purchase Invoices ID'),
            'photo_path'           => Yii::t('app', 'Photo Path'),
        ];
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
     * creates Url for the file
     *
     * @return string the created URL
     */
    public function getFileUrl()
    {
        return DIRECTORY_SEPARATOR . Url::to(Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $this->photo_path);
    }

    /**
     * returns absolute local file path
     *
     * @return string
     */
    public function getAbsolutePath()
    {
        return Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryMail'] . DIRECTORY_SEPARATOR . $this->photo_path;
    }
}