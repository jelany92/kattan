<?php

use yii\db\Migration;

/**
 * Class m200513_060200_gallery_article
 */
class m200513_060200_gallery_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('detail_gallery_article', [
            'id'              => $this->primaryKey(),
            'company_id'      => $this->integer(),
            'category_id'     => $this->integer(),
            'article_name_ar' => $this->string(100),
            'article_name_en' => $this->string(100),
            'link_to_preview' => $this->string(),
            'description'     => $this->text(),
            'type'            => $this->string(),
            'selected_date'   => $this->date(),
            'created_at'      => $this->dateTime(),
            'updated_at'      => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_detail_gallery_article_user_id', 'detail_gallery_article', 'company_id', 'user', 'id');
        $this->addForeignKey('fk_detail_gallery_article_category_id', 'detail_gallery_article', 'category_id', 'category', 'id');


        $this->createTable('book_gallery', [
            'id'                        => $this->primaryKey(),
            'detail_gallery_article_id' => $this->integer(),
            'author_name'               => $this->string()->notNull(),
            'book_photo'                => $this->string(),
            'book_pdf'                  => $this->string(),
            'book_serial_number'        => $this->string(),
            'created_at'                => $this->dateTime(),
            'updated_at'                => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_book_gallery_detail_gallery_article_id', 'book_gallery', 'detail_gallery_article_id', 'detail_gallery_article', 'id');


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_detail_gallery_article_user_id', 'detail_gallery_article');
        $this->dropForeignKey('fk_detail_gallery_article_category_id', 'detail_gallery_article');
        $this->dropForeignKey('fk_book_gallery_detail_gallery_article_id', 'book_gallery');
        $this->dropTable('detail_gallery_article');
        $this->dropTable('book_gallery');
    }

}
