<?php

namespace backend\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "capital".
 *
 * @property int $id
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
            [['name', 'amount', 'selected_date', 'status'], 'required'],
            [['amount'], 'number'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
            [['status'], 'string'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t('app', 'ID'),
            'name'          => Yii::t('app', 'Name'),
            'amount'        => Yii::t('app', 'Amount'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'status'        => Yii::t('app', 'Status'),
            'created_at'    => Yii::t('app', 'Created At'),
            'updated_at'    => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array|bool
     */
    public static function sumResultCapital()
    {
        $entry = (new Query())->select(['result' => 'SUM(c.amount)'])->from(['c' => 'capital'])->andWhere(['status' => 'Entry'])->one();
        $withdrawal = (new Query())->select(['result' => 'SUM(c.amount)'])->from(['c' => 'capital'])->andWhere(['status' => 'Withdrawal'])->one();
        return $entry['result'] - $withdrawal['result'];
    }
}
