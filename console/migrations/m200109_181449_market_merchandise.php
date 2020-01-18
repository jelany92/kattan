<?php

use yii\db\Migration;

/**
 * Class m200109_181449_market_merchandise
 */
class m200109_181449_market_merchandise extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id'            => $this->primaryKey(),
            'category_name' => $this->string(50)->notNull()->unique(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('article', [
            'id'                      => $this->primaryKey(),
            'category_id'             => $this->integer(),
            'article_name'            => $this->string(100)->notNull(),
            'article_photo'           => $this->string(),
            'article_count'           => $this->integer(),
            'article_unit'            => $this->string(25),
            'article_total_prise'     => $this->double(),
            'article_prise_per_piece' => $this->double(),
            'status'                  => $this->string(50),
            'seller_name'             => $this->string(100),
            'selected_date'           => $this->date(),
            'created_at'              => $this->dateTime(),
            'updated_at'              => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_article_category_id', 'article', 'category_id', 'category', 'id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_article_category_id', 'article');
        $this->dropTable('article');
        $this->dropTable('category');
    }

}
