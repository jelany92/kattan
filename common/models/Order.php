<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $shop_id
 * @property int|null $article_info_id
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property ArticleInfo $articleInfo
 * @property User $user
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'shop_id', 'article_info_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['article_info_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleInfo::class, 'targetAttribute' => ['article_info_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app', 'ID'),
            'user_id'         => Yii::t('app', 'User ID'),
            'shop_id'         => Yii::t('app', 'Shop ID'),
            'article_info_id' => Yii::t('app', 'Article Info ID'),
            'created_at'      => Yii::t('app', 'Created At'),
            'updated_at'      => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[ArticleInfo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getArticleInfo()
    {
        return $this->hasOne(ArticleInfo::class, ['id' => 'article_info_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
