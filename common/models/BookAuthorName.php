<?php

namespace common\models;

use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "book_author_name".
 *
 * @property int $id
 * @property int|null $company_id
 * @property string $name
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property User $company
 * @property BookGallery[] $bookGalleries
 */

class BookAuthorName extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_author_name';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'company_id'], 'integer'],
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'         => Yii::t('app', 'ID'),
            'company_id' => Yii::t('app', 'Company ID'),
            'name'       => Yii::t('app', 'Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(User::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[BookGalleries]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBookGalleries()
    {
        return $this->hasMany(BookGallery::class, ['book_author_name_id' => 'id']);
    }


    /**
     * @return array
     */
    public static function getBookAuthorNameList(): array
    {
        return ArrayHelper::map(self::find()->andWhere(['company_id' => Yii::$app->user->id])->all(), 'id', 'name');
    }
}
