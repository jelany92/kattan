<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "admin_user_role_log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $modified_at
 * @property string $role
 *
 * @property AdminUser $user
 */
class AdminUserRoleLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_user_role_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'role'], 'required'],
            [['user_id'], 'integer'],
            [['modified_at'], 'safe'], // handled by DB
            [['role'], 'string', 'max' => 64],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'user_id'     => Yii::t('app', 'User ID'),
            'modified_at' => Yii::t('app', 'Geändert am '),
            'role'        => Yii::t('app', 'Rolle'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AdminUser::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\queries\AdminUserRoleLogQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\AdminUserRoleLogQuery(get_called_class());
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['modified_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
