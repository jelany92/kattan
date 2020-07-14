<?php

namespace backend\models;

use common\components\ChangeFormat;
use common\models\traits\TimestampBehaviorTrait;
use common\models\AdminUser;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "tax_office".
 *
 * @property int $id
 * @property double $income
 * @property string $selected_date
 * @property string $reason
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class TaxOffice extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tax_office';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['income', 'selected_date'], 'required'],
            [['income'], 'validateNumber'],
            [['reason'], 'string'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => AdminUser::class, 'targetAttribute' => ['company_id' => 'id']],
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'income'        => Yii::t('app', 'Expense'),
            'reason'        => Yii::t('app', 'Reason'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(AdminUser::class, ['id' => 'company_id']);
    }

    /**
     * @return array|bool
     */
    public static function sumResultTaxOffice()
    {
        return (new Query())->select(['result' => 'SUM(e.income)'])->from(['e' => 'tax_office'])->andWhere(['company_id' => Yii::$app->user->id])->one();
    }
}
