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
    public function safeUp()
    {
        $this->createTable('capital', [
            'id'            => $this->primaryKey(),
            'company_id'    => $this->integer(),
            'name'          => $this->string(100)->notNull(),
            'amount'        => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'status'        => "ENUM('Entry', 'Withdrawal') NOT NULL",
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_capital_user_id', 'capital', 'company_id', 'user', 'id');

        $this->createIndex('name_unique', 'capital', [
            'company_id',
            'name',
            'status',
        ], true);

        $this->createTable('incoming_revenue', [
            'id'                     => $this->primaryKey(),
            'daily_incoming_revenue' => $this->double()->notNull(),
            'selected_date'          => $this->date()->notNull()->unique(),
            'created_at'             => $this->dateTime(),
            'updated_at'             => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('purchases', [
            'id'            => $this->primaryKey(),
            'purchases'     => $this->double()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('market_expense', [
            'id'            => $this->primaryKey(),
            'expense'       => $this->double()->notNull(),
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

        $this->createTable('debt', [
            'id'            => $this->primaryKey(),
            'amount_debt'   => $this->integer()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('payment_in_installment', [
            'id'            => $this->primaryKey(),
            'debt_id'       => $this->integer()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_payment_in_installment_debt_id', 'payment_in_installment', 'debt_id', 'debt', 'id');

        $this->createTable('tax_office', [
            'id'            => $this->primaryKey(),
            'income'        => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_capital_user_id', 'capital');
        $this->dropForeignKey('fk_payment_in_installment_debt_id', 'payment_in_installment');
        $this->dropForeignKey('fk_salary_of_employ_reason_of_withdrawal_id', 'salary_of_employ_reason_of_withdrawal');
        $this->dropTable('salary_of_employ_reason_of_withdrawal');
        $this->dropTable('tax_office');
        $this->dropTable('payment_in_installment');
        $this->dropTable('debt');
        $this->dropTable('market_expense');
        $this->dropTable('salary_of_employ');
        $this->dropTable('incoming_revenue');
        $this->dropTable('purchases');
        $this->dropTable('capital');
    }
}

