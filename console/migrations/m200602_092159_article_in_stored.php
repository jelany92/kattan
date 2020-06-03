<?php

use yii\db\Migration;

/**
 * Class m200602_092159_article_in_stored
 */
class m200602_092159_article_in_stored extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // article inventory
        $this->createTable('article_inventory', [
            'id'             => $this->primaryKey(),
            'inventory_name' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        // article stored
        $this->createTable('article_in_stored', [
            'id'                   => $this->primaryKey(),
            'article_info_id'      => $this->integer(),
            'article_inventory_id' => $this->integer(),
            'count'                => $this->integer(),
            'selected_date'        => $this->date(),
            'created_at'           => $this->dateTime(),
            'updated_at'           => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_article_in_stored_article_info_id', 'article_in_stored', 'article_info_id', 'article_info', 'id');
        $this->addForeignKey('fk_article_in_stored_article_inventory_id', 'article_in_stored', 'article_inventory_id', 'article_inventory', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_in_stored_article_inventory_id', 'article_in_stored');
        $this->dropForeignKey('fk_article_in_stored_article_info_id', 'article_in_stored');
        $this->dropTable('article_in_stored');
        $this->dropTable('article_inventory');
    }
}
