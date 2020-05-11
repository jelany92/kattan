<?php

namespace common\models;

use backend\models\Capital;
use backend\models\IncomingRevenue;
use backend\models\MarketExpense;
use backend\models\PurchaseInvoices;
use backend\models\Purchases;
use backend\models\TaxOffice;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $company_name
 * @property string $auth_key
 * @property string $password_hash
 * @property string $repeat_password
 * @property string|null $password_reset_token
 * @property string $email
 * @property string $category
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Order[] $orders
 */
class UserModel extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'company_name', 'password_hash', 'repeat_password', 'email'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            ['repeat_password', 'compare', 'compareAttribute' => 'password_hash'],
            [['username', 'company_name', 'password_hash', 'repeat_password', 'password_reset_token', 'email', 'category'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['email'], 'email'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'username'             => Yii::t('app', 'Username'),
            'company_name'         => Yii::t('app', 'Company Name'),
            'auth_key'             => Yii::t('app', 'Auth Key'),
            'password_hash'        => Yii::t('app', 'Password'),
            'repeat_password'      => Yii::t('app', 'Repeat Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email'                => Yii::t('app', 'Email'),
            'category'             => Yii::t('app', 'Category'),
            'created_at'           => Yii::t('app', 'Created At'),
            'updated_at'           => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return ActiveQuery
     */
    public function getOrders() : ActiveQuery
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return ActiveQuery
     */
    public function getArticleInfo() : ActiveQuery
    {
        return $this->hasMany(ArticleInfo::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() : ActiveQuery
    {
        return $this->hasMany(Category::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Capital]].
     *
     * @return ActiveQuery
     */
    public function getCapital() : ActiveQuery
    {
        return $this->hasMany(Capital::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[CustomerEmployer]].
     *
     * @return ActiveQuery
     */
    public function getCustomerEmployer() : ActiveQuery
    {
        return $this->hasMany(CustomerEmployer::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Debt]].
     *
     * @return ActiveQuery
     */
    public function getDebt() : ActiveQuery
    {
        return $this->hasMany(Debt::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[IncomingRevenue]].
     *
     * @return ActiveQuery
     */
    public function getIncomingRevenue() : ActiveQuery
    {
        return $this->hasMany(IncomingRevenue::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[IncomingRevenue]].
     *
     * @return ActiveQuery
     */
    public function getMarketExpense() : ActiveQuery
    {
        return $this->hasMany(MarketExpense::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[Purchases]].
     *
     * @return ActiveQuery
     */
    public function getPurchases() : ActiveQuery
    {
        return $this->hasMany(Purchases::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[PurchaseInvoices]].
     *
     * @return ActiveQuery
     */
    public function getPurchaseInvoices() : ActiveQuery
    {
        return $this->hasMany(PurchaseInvoices::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[SalaryOfEmploy]].
     *
     * @return ActiveQuery
     */
    public function getSalaryOfEmploy() : ActiveQuery
    {
        return $this->hasMany(SalaryOfEmploy::class, ['company_id' => 'id']);
    }

    /**
     * Gets query for [[TaxOffice]].
     *
     * @return ActiveQuery
     */
    public function getTaxOffice() : ActiveQuery
    {
        return $this->hasMany(TaxOffice::class, ['company_id' => 'id']);
    }
}
