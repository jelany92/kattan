<?php

namespace app\models\query\traits;

/**
 * Trait UserTrait
 * @package app\models\query\traits
 */
trait UserTrait {

    /**
     * wenn user id gleich id
     * @param $id
     * @return $this
     */
    public function user($id){
        return $this->andWhere(['user_id' => $id]);
    }
}