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
        // rechnug
        $this->createTable('purchase_invoices', [
            'id'                  => $this->primaryKey(),
            'invoice_name'        => $this->string(100)->notNull(),
            'invoice_description' => $this->string()->notNull(),
            'seller_name'         => $this->string(100)->notNull(),
            'amount'              => $this->double()->notNull(),
            'selected_date'       => $this->date(),
            'created_at'          => $this->dateTime(),
            'updated_at'          => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        //rechnung foto
        $this->createTable('invoices_photo', [
            'id'                   => $this->primaryKey(),
            'purchase_invoices_id' => $this->integer(),
            'photo_path'           => $this->string(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_invoices_photo_purchase_invoices_id', 'invoices_photo', 'purchase_invoices_id', 'purchase_invoices', 'id');

        //kategory
        $this->createTable('category', [
            'id'            => $this->primaryKey(),
            'category_name' => $this->string(50)->notNull()->unique(),
            'created_at'    => $this->dateTime(),
            'updated_at'    => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        //artikele information
        $this->createTable('article_info', [
            'id'                => $this->primaryKey(),
            'category_id'       => $this->integer(),
            'article_name_ar'   => $this->string(100)->notNull(),
            'article_name_en'   => $this->string(100),
            'article_quantity'  => $this->integer(),
            'article_unit'      => $this->string(10),
            'article_photo'     => $this->string(),
            'article_buy_price' => $this->double(),
            'created_at'        => $this->dateTime(),
            'updated_at'        => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_article_info_category_id', 'article_info', 'category_id', 'category', 'id');

        // artikel prise
        $this->createTable('article_price', [
            'id'                      => $this->primaryKey(),
            'article_info_id'         => $this->integer(),
            'purchase_invoices_id'    => $this->integer(),
            'article_count'           => $this->integer(),
            'article_total_prise'     => $this->double(),
            'article_prise_per_piece' => $this->double(),
            'status'                  => $this->string(50),
            'selected_date'           => $this->date(),
            'created_at'              => $this->dateTime(),
            'updated_at'              => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_article_price_article_info_id', 'article_price', 'article_info_id', 'article_info', 'id');
        $this->addForeignKey('fk_article_price_purchase_invoices_id', 'article_price', 'purchase_invoices_id', 'purchase_invoices', 'id');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_invoices_photo_purchase_invoices_id', 'invoices_photo');
        $this->dropForeignKey('fk_article_price_purchase_invoices_id', 'article_price');
        $this->dropForeignKey('fk_article_price_article_info_id', 'article_price');
        $this->dropForeignKey('fk_article_info_category_id', 'article_info');
        $this->dropTable('invoices_photo');
        $this->dropTable('purchase_invoices');
        $this->dropTable('article_price');
        $this->dropTable('article_info');
        $this->dropTable('category');
    }
}
