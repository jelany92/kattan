<?php

use yii\db\Migration;

/**
 * Class m200709_115857_test
 */
class m200709_115857_test extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('quiz_main_category_exercise', [
            'id'                          => $this->primaryKey(),
            'main_category_exercise_name' => $this->string(100)->notNull(),
            'description'                 => $this->text(),
            'question_type'               => $this->string(),
            'created_at'                  => $this->dateTime(),
            'updated_at'                  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->addColumn('quiz_exercise', 'main_category_exercise_id', $this->integer());

        $this->addForeignKey('quiz_exercise_main_category_exercise_id', 'quiz_exercise', 'main_category_exercise_id', 'quiz_main_category_exercise', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('quiz_exercise_main_category_exercise_id', 'quiz_exercise');
        $this->dropColumn('quiz_exercise', 'main_category_exercise_id');
        $this->dropTable('quiz_main_category_exercise');
    }

}
