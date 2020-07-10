<?php

namespace backend\models\quiz;

use Yii;
use yii\base\Model;
use backend\models\quiz\Students;


class SubmitForm extends Model
{
    public $token;
    public $message = 'Invalid token input.';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['token', 'required'],
            ['token', 'validateToken'],
            ['token', 'exist', 'targetClass' => Students::class]
        ];
    }
    
    public function validateTokens(){
        if(!Students::findOne(['token' => $this->token])){
            $this->addError('token', $this->message);
        }
    }
    
    public function validateToken(){
        return Students::findOne(['token' => $this->token]) ? true : null;
    }
}
