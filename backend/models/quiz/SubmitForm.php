<?php

namespace backend\models\quiz;

use Yii;
use yii\base\Model;
use backend\models\quiz\StudentsCrud;


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
            ['token', 'exist', 'targetClass' => StudentsCrud::class]
        ];
    }
    
    public function validateTokens(){
        if(!StudentsCrud::findOne(['token' => $this->token])){
            $this->addError('token', $this->message);
        }
    }
    
    public function validateToken(){
        return StudentsCrud::findOne(['token' => $this->token]) ? true : null;
    }
}
