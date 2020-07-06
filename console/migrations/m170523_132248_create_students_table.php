<?php

use yii\db\Migration;

/**
 * Handles the creation of table `students`.
 */
class m170523_132248_create_students_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quiz_students', [
            'id'             => $this->primaryKey(),
            'token'          => $this->string(),
            'name'           => $this->string(),
            'correct_answer' => $this->smallInteger(),
            'wrong_answer'   => $this->smallInteger(),
            'score'          => $this->smallInteger(),
            'is_complete'    => $this->boolean(),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quiz_students');
    }
}
