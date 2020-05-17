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


        $this->createTable('incoming_revenue', [
            'id'                     => $this->primaryKey(),
            'company_id'             => $this->integer(),
            'daily_incoming_revenue' => $this->double()->notNull(),
            'selected_date'          => $this->date()->notNull(),
            'created_at'             => $this->dateTime(),
            'updated_at'             => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createIndex('name_unique', 'incoming_revenue', [
            'company_id',
            'selected_date',
        ], true);
        $this->addForeignKey('fk_incoming_revenue_user_id', 'incoming_revenue', 'company_id', 'user', 'id');


        $this->createTable('purchases', [
            'id'            => $this->primaryKey(),
            'company_id'    => $this->integer(),
            'purchases'     => $this->double()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->createIndex('name_unique', 'incoming_revenue', [
            'company_id',
            'reason',
            'purchases',
            'selected_date',
        ], true);
        $this->addForeignKey('fk_purchases_user_id', 'purchases', 'company_id', 'user', 'id');

        $this->createTable('market_expense', [
            'id'            => $this->primaryKey(),
            'company_id'    => $this->integer(),
            'expense'       => $this->double()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_market_expense_user_id', 'market_expense', 'company_id', 'user', 'id');

        $this->createTable('salary_of_employ', [
            'id'            => $this->primaryKey(),
            'company_id'    => $this->integer(),
            'employ_name'   => $this->string()->notNull(),
            'salary'        => $this->integer()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_salary_of_employ_user_id', 'salary_of_employ', 'company_id', 'user', 'id');

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
            'company_id'    => $this->integer(),
            'amount_debt'   => $this->integer()->notNull(),
            'reason'        => $this->string()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_debt_user_id', 'debt', 'company_id', 'user', 'id');

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
            'company_id'    => $this->integer(),
            'income'        => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_tax_office_user_id', 'tax_office', 'company_id', 'user', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_capital_user_id', 'capital');
        $this->dropForeignKey('fk_incoming_revenue_user_id', 'incoming_revenue');
        $this->dropForeignKey('fk_market_expense_user_id', 'market_expense');
        $this->dropForeignKey('fk_salary_of_employ_user_id', 'salary_of_employ');
        $this->dropForeignKey('fk_purchases_user_id', 'purchases');
        $this->dropForeignKey('fk_debt_user_id', 'debt');
        $this->dropForeignKey('fk_tax_office_user_id', 'tax_office');

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

