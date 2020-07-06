<?php

use yii\db\Migration;

/**
 * Handles the creation of table `answer`.
 */
class m170523_154712_create_answer_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('quiz_student_answers', [
            'id'             => $this->primaryKey(),
            'excercise_id'   => $this->integer(),
            'student_id'     => $this->integer(),
            'student_answer' => $this->char(),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        //         add foreign key for table `students`
        $this->addForeignKey('fk-student_answers-student_id', 'quiz_student_answers', 'student_id', 'quiz_students', 'id', 'CASCADE');

        $this->addForeignKey('fk-student_answers-excercise_id', 'quiz_student_answers', 'excercise_id', 'quiz_excercise', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('quiz_student_answers');
    }
}
