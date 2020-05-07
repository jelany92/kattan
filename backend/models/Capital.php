<?php

namespace backend\models;

use common\components\ChangeFormat;
use common\models\query\traits\TimestampBehaviorTrait;
use common\models\User;
use common\models\UserModel;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "capital".
 *
 * @property int $id
 * @property int $company_id
 * @property string $name
 * @property float $amount
 * @property string $selected_date
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Capital extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'capital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['company_id'], 'integer'],
            [['name', 'amount', 'selected_date', 'status'], 'required'],
            [['amount'], 'validateNumber'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 100],
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
            'company_id'    => Yii::t('app', 'Company Name'),
            'name'          => Yii::t('app', 'Name'),
            'amount'        => Yii::t('app', 'Amount'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'status'        => Yii::t('app', 'Status'),
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
     * @return array|bool
     */
    public static function sumResultPurchases()
    {
        return (new Query())->select(['result' => 'SUM(ir.purchases)'])->from(['ir' => 'purchases'])->andWhere(['company_id' => Yii::$app->user->id])->one();
    }

    /**
     * @return array|bool
     */
    public static function sumResultCapital()
    {
        $entry = (new Query())->select(['result' => 'SUM(c.amount)'])->from(['c' => 'capital'])->andWhere(['status' => 'Entry', 'company_id' => Yii::$app->user->id])->one();
        $withdrawal = (new Query())->select(['result' => 'SUM(c.amount)'])->from(['c' => 'capital'])->andWhere(['status' => 'Withdrawal', 'company_id' => Yii::$app->user->id])->one();
        return $entry['result'] - $withdrawal['result'];
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
}
