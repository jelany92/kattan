<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql')
        {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('user', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notNull()->unique(),
            'company_name'         => $this->string()->notNull(),
            'auth_key'             => $this->string(32),
            'password_hash'        => $this->string()->notNull(),
            'repeat_password'      => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email'                => $this->string()->notNull()->unique(),
            'category'             => $this->string()->notNull(),
            //'status'               => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'           => $this->dateTime(),
            'updated_at'           => $this->dateTime(),
        ], $tableOptions);

        $this->createTable('user_login_log', [
            'id'       => $this->primaryKey(),
            'user_id'  => $this->integer(11)->notNull(),
            'ip'       => $this->string(128)->notNull(),
            'login_at' => 'datetime DEFAULT CURRENT_TIMESTAMP',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey("user_login_log_user_id", "user_login_log", "user_id", "user", "id");

    }

    public function down()
    {
        $this->dropForeignKey('user_login_log_user_id', 'user_login_log');
        $this->dropTable('user_login_log');
        $this->dropTable('user');
    }
}
