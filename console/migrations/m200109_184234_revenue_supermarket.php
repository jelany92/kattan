<?php

use yii\db\Migration;

/**
 * Class m200109_184234_revenue_supermarket
 */
class m200109_184234_revenue_supermarket extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function _safeUp()
    {
        $this->createTable('capital', [
            'id'            => $this->primaryKey(),
            'name'          => $this->string(100)->notNull()->unique(),
            'amount'        => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'status'        => "ENUM('Entry', 'Withdrawal') NOT NULL",
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createTable('incoming_revenue', [
            'id'            => $this->primaryKey(),
            'daily_incoming_revenue' => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull()->unique(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createTable('purchases', [
            'id'            => $this->primaryKey(),
            'purchases'     => $this->double()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('salary_of_employ', [
            'id'            => $this->primaryKey(),
            'employ_name'   => $this->string()->notNull(),
            'salary'        => $this->integer()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('salary_of_employ_reason_of_withdrawal', [
            'id'            => $this->primaryKey(),
            'employ_id'     => $this->integer(),
            'withdrawal'    => $this->integer()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_salary_of_employ_reason_of_withdrawal_id', 'salary_of_employ_reason_of_withdrawal', 'employ_id', 'salary_of_employ', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function _safeDown()
    {
        $this->dropForeignKey('fk_salary_of_employ_reason_of_withdrawal_id', 'salary_of_employ_reason_of_withdrawal');
        $this->dropTable('salary_of_employ_reason_of_withdrawal');
        $this->dropTable('salary_of_employ');
        $this->dropTable('incoming_revenue');
        $this->dropTable('purchases');
        $this->dropTable('capital');
    }
}

