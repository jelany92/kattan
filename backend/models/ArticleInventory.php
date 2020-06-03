<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "article_inventory".
 *
 * @property int $id
 * @property string $inventory_name
 *
 * @property ArticleInStored[] $articleInStoreds
 */
class ArticleInventory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article_inventory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inventory_name'], 'required'],
            [['inventory_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'             => Yii::t('app', 'ID'),
            'inventory_name' => Yii::t('app', 'Inventory Name'),
        ];
    }

    /**
     * Gets query for [[ArticleInStoreds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInStoreds()
    {
        return $this->hasMany(ArticleInStored::class, ['article_inventory_id' => 'id']);
    }
}
