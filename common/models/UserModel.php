<?php

namespace common\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;

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
            [['username', 'company_name', 'password_hash', 'repeat_password', 'password_reset_token', 'email', 'category'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
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
            'password_hash'        => Yii::t('app', 'Password Hash'),
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
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }
}
