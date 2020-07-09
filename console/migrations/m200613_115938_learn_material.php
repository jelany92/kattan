<?php

use yii\db\Migration;

/**
 * Class m200613_115938_learn_material
 */
class m200613_115938_learn_material extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('learn_staff', [
            'id'          => $this->primaryKey(),
            'staff_name'  => $this->string(100)->notNull(),
            'description' => $this->text(),
            'created_at'  => $this->dateTime(),
            'updated_at'  => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        $this->createTable('learn_material', [
            'id'             => $this->primaryKey(),
            'learn_staff_id' => $this->integer(),
            'material_name'  => $this->string(100)->notNull(),
            'material_link'  => $this->string()->notNull(),
            'created_at'     => $this->dateTime(),
            'updated_at'     => $this->dateTime(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');
        $this->addForeignKey('fk_learn_material_learn_staff_id', 'learn_material', 'learn_staff_id', 'learn_staff', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_learn_material_learn_staff_id', 'learn_material');
        $this->dropTable('learn_material');
        $this->dropTable('learn_staff');

    }

}
