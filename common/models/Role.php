<?php

namespace common\models;

use common\models\traits\SortableBehaviorTrait;
use Yii;

/**
 * This is the model class for table "role".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $sort
 * @property string $created_at
 * @property string $updated_at
 */
class Role extends \yii\db\ActiveRecord
{
    use SortableBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'trim'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['sort'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('app', 'ID'),
            'name'        => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Beschreibung'),
            'sort'        => Yii::t('app', 'Sortierung'),
            'created_at'  => Yii::t('app', 'Erstellt am'),
            'updated_at'  => Yii::t('app', 'Aktualisiert am'),
        ];
    }


    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        // remove trailing empty <p> Tags
        $this->description = preg_replace('/(<p>&nbsp;<\/p>)+$/', '', $this->description);

        return parent::beforeSave($insert);
    }


    /**
     * Returns an ordered List of categories ids and names
     * @return array
     */
    public static function getList(){
        return Role::find()->orderBy(['name' => SORT_ASC])->all();
    }
}
