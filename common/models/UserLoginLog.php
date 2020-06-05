<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_login_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $ip
 * @property string|null $login_at
 *
 * @property User $user
 */
class UserLoginLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_login_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'ip'], 'required'],
            [['user_id'], 'integer'],
            [['login_at'], 'safe'],
            [['ip'], 'string', 'max' => 128],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'ip' => Yii::t('app', 'Ip'),
            'login_at' => Yii::t('app', 'Login At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
