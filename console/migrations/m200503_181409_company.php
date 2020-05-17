<?php

use yii\db\Migration;

/**
 * Class m200503_181409_company
 */
class m200503_181409_company extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function _safeUp()
    {
        $this->createTable('customer_info', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(),
            'first_name'      => $this->string()->notNull(),
            'last_name'       => $this->string()->notNull(),
            'email'           => $this->string()->notNull()->unique(),
            'password'        => $this->string()->notNull(),
            'password_repeat' => $this->string()->notNull(),
            'created_at'      => $this->dateTime(),
            'updated_at'      => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_customer_info_user_id', 'customer_info', 'user_id', 'user', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_customer_info_user_id', 'customer_info');
        $this->dropTable('customer_info');
    }

}
