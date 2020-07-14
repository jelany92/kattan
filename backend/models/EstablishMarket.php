<?php

namespace backend\models;

use common\components\ChangeFormat;
use common\models\traits\TimestampBehaviorTrait;
use common\models\User;
use Yii;

/**
 * This is the model class for table "establish_market".
 *
 * @property int $id
 * @property int|null $company_id
 * @property int $amount
 * @property string $reason
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $company
 */
class EstablishMarket extends \yii\db\ActiveRecord
{

    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'establish_market';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id'], 'integer'],
            [['amount'], 'validateNumber'],
            [['reason', 'selected_date'], 'required'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['reason'], 'string', 'max' => 255],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'company_id'    => Yii::t('app', 'Company ID'),
            'amount'        => Yii::t('app', 'Amount'),
            'reason'        => Yii::t('app', 'Reason'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param string $attribute
     */
    public function validateNumber(string $attribute) : void
    {
        ChangeFormat::validateNumber($this, $attribute);
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(User::class, ['id' => 'company_id']);
    }
}
