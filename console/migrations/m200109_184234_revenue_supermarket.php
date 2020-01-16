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
        $this->createTable('incoming_revenue', [
            'id'            => $this->primaryKey(),
            'daily_incoming_revenue' => $this->double()->notNull(),
            'selected_date' => $this->date()->notNull(),
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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('incoming_revenue');
        $this->dropTable('purchases');
    }
}

