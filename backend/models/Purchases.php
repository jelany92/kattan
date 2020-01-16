<?php

namespace backend\models;

use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "purchases".
 *
 * @property int $id
 * @property double $purchases
 * @property string $reason
 * @property string $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Purchases extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'purchases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['purchases', 'selected_date', 'reason'], 'required'],
            [['purchases'], 'double'],
            [['selected_date', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'purchases' => Yii::t('app', 'Purchases'),
            'reason' => Yii::t('app', 'Purchases'),
            'selected_date' => Yii::t('app', 'Selected Date'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return array|bool
     */
    public static function sumResultPurchases()
    {
        return (new Query())->select(['result' => 'SUM(ir.purchases)'])->from(['ir' => 'purchases'])->one();
    }



    /**
     * sammelt date und zeit in einem spalte
     * es wird benutzt in actionCreate
     * @return mixed
     *
     * @param \DateTime $date
     * @param string    $time
     */
    public function dateFormat(\DateTime $date, $time)              // sammelt date und zeit in einem spalte
    {
        $timeDT = \DateTime::createFromFormat('H:i', $time);
        $date->setTime($timeDT->format('G'), $timeDT->format('i'));
        return $date;
    }
}
