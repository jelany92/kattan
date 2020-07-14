<?php

namespace common\models\traits;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * Trait SortableBehaviorTrait
 * This behavior supports automatically updating the timestamp attributes of an
 * Active Record model anytime the model is saved via insert(), update() or save() method.
 *
 * Additional it handles the sortable functionality
 */
trait SortableBehaviorTrait
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                // if you're using datetime instead of UNIX timestamp:
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => 'sjaakp\sortable\Sortable',
                'orderAttribute' => 'sort'
            ],
        ];
    }
}