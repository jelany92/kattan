<?php
/**
 * Created by PhpStorm.
 * User: jelani.qattan
 * Date: 28.06.2018
 * Time: 10:30
 */

namespace common\models\auth;


use yii\rbac\Item;

class TaskItem extends Item
{
    /**
     * @var int
     */
    public $type = AuthItem::TYPE_TASK;

}