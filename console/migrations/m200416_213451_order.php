<?php

use yii\db\Migration;

/**
 * Class m200416_213451_order
 */
class m200416_213451_order extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order', [
            'id'              => $this->primaryKey(),
            'user_id'         => $this->integer(),
            'shop_id'         => $this->integer(),
            'article_info_id' => $this->integer(),
            'created_at'      => $this->dateTime(),
            'updated_at'      => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_order_user_id', 'order', 'user_id', 'user', 'id');
        //$this->addForeignKey('fk_shop_id_id', 'order', 'user_id', 'user', 'id');
        $this->addForeignKey('fk_order_article_info_id', 'order', 'article_info_id', 'article_info', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_order_article_info_id', 'order');
        $this->dropForeignKey('fk_order_user_id', 'order');
        $this->dropTable('order');
    }

}
