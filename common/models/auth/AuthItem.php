<?php

namespace common\models\auth;

use common\exceptions\PermissionException;
use common\models\auth\queries\AuthItemQuery;
use Yii;

/**
 * This is the model class for table "auth_item".
 *
 * @property string           $name
 * @property int              $type
 * @property string           $description
 * @property string           $rule_name
 * @property resource         $data
 * @property int              $created_at
 * @property int              $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItemChild[]  $authItemChildren
 * @property AuthItemChild[]  $authItemChildren0
 * @property AuthItem[]       $children
 * @property AuthItem[]       $parents
 */
class AuthItem extends \yii\db\ActiveRecord
{
    const TYPE_ROLE       = \yii\rbac\Item::TYPE_ROLE;
    const TYPE_PERMISSION = \yii\rbac\Item::TYPE_PERMISSION;
    const TYPE_TASK       = 3;
    
    const TASK_DEACTIVATE_USER_STAMM = 'deactivate.user-stamm';
    const TASK_TOGGLE_TERMINATED_MODUL_USER_DETAIL = 'toggle-terminated.modul-user-detail';

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';

    const SUPER_PERMISSION = "*.*";
    const SUPER_ADMIN_ROLE = 'admin';

    // RBAC representation of this object
    public $authObject = null;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            [['name', 'type'], 'required'],
            [['name'], 'unique'],
            [['name', 'description'], 'filter', 'filter' => 'trim'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['type'], 'in', 'range' => array_keys(self::getTypeList()),],
            [['data'], 'string'],
            [['description'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64,],
            [['name'], 'unique', 'targetAttribute' => 'name', 'filter' => ['!=', 'name', Yii::$app->request->get('name'),],],

        ];
    }

    public function scenarios()
    {
        $scenarios                        = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['name', 'type', 'description'];
        $scenarios[self::SCENARIO_UPDATE] = ['description'];
        return $scenarios;
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return ['name' => Yii::t('app', 'Name'), 'type' => Yii::t('app', 'Typ'), 'description' => Yii::t('app', 'Beschreibung'), 'rule_name' => Yii::t('app', 'Rule Name'), 'data' => Yii::t('app', 'Data'), 'created_at' => Yii::t('app', 'Created At'), 'updated_at' => Yii::t('app', 'Updated At'),];
    }

    public function getTypeColumn()
    {
        return ['attribute' => 'type',
                'label'     => 'Typ',
                'value'     => function ($model) {
                    return $model->getTypeName();
                },];

    }

    /**
     * Returns the list of available Auth Item Types
     *
     * @return array
     */
    public static function getTypeList()
    {
        $typeList = [

            self::TYPE_ROLE       => Yii::t('app', 'Rolle'),
            self::TYPE_TASK       => Yii::t('app', 'Aufgabe'),
            self::TYPE_PERMISSION => Yii::t('app', 'Recht'),

        ];
        return $typeList;
    }

    /**
     * returns a list of AutItems those of which may be assigned to the given AuthItem
     *
     * @param AuthItem $item
     *
     * @return array
     */
    public static function getAssignableList(AuthItem $item)
    {
        $result = []; // Permissions are not allowed to have assignments

        // set type filter first
        $typeFilter = self::getAllowedTypesForAssignment($item->type);

        if (0 < count($typeFilter))
        {
            $objList = self::getNotYetAssigned($item, $typeFilter);
            foreach ($typeFilter as $type)
            {
                $entries = self::createArrayForType($objList, $type);
                if (0 < count($entries))
                {
                    $result[AuthItem::getTypeNameS($type)] = $entries;
                }
            }
        }
        return $result;
    }


    /**
     * returns a list of names of authItem objects which have not yet been assigned to a parent object
     *
     * @param $typeFilter array of int types of object to be searched for, @see common\models\auth\AuthItem::TYPE_xxx
     *
     * @return array of AuthItems
     */
    public static function getNotYetAssigned(AuthItem $parent, $typeFilter)
    {
        // typefilter must not contain a type higher than parent
        // e.g. parent type is task AND typeFilter contains role or
        // not allowed -> throw Exception
        self::checkTypeIntegrity($parent->type, $typeFilter);

        $subQueryResult = self::getAssigned($parent);
        $nameList       = [];
        $nameList []    = $parent->name; // Don't assign itself
        foreach ($subQueryResult as $authItem)
        {
            $nameList [] = $authItem->name;
        }
        $query = AuthItem::find()
                         ->where(['in', 'type', $typeFilter])
                         ->andWhere(['not in', 'name', $nameList])
                         ->andWhere(['!=',
                             'name',
                             self::SUPER_ADMIN_ROLE])// SUPER_ADMIN will never be assigned to anything
                         ->andWhere(['!=', 'name', '*.*']); //  *.* will never be assigned to anything except SUPER_ADMIN
        $sql   = $query->createCommand()
                       ->getRawSql();
        return $query->all();

    }


    /**
     * @param AuthItem $parent
     *
     * @return mixed
     */
    private static function getAssigned(AuthItem $parent)
    {
        return AuthItem::find()
                       ->alias('ai')
                       ->innerJoin(AuthItemChild::tableName() . ' AS c', 'ai.name = c.child')
                       ->where(['=', 'c.parent', $parent->name])
                       ->all();
    }

    /**
     * @param $objList AuthItem[]
     * @param $type
     *
     * @return array of item names
     */
    private static function createArrayForType($objList, $type)
    {
        /** @var  $objList AuthItem[] */
        $result = [];
        foreach ($objList as $item)
        {
            if ($type == $item->type)
            {
                $result[$item->name] = $item->name;
            }
        }
        return $result;
    }

    /**
     * Returns the Auth Item Type Name for the current object
     * @return mixed
     */
    public function getTypeName()
    {
        return self::getTypeNameS($this->type);
    }

    /**
     * @param $type
     *
     * @return bool|mixed
     */
    public static function getTypeNameS($type)
    {
        if (in_array($type, array_keys(self::getTypeList())))
        {
            return self::getTypeList()[$type];
        }
        return false;
    }

    /**
     * check if given constant is valid
     *
     * @param $type
     *
     * @return bool
     */
    public static function isValid($type)
    {
        return in_array($type, array_keys(self::getTypeList()));
    }


    /**
     * singleton method,
     * creates RBAC object for this model and returns it
     *
     * @return TaskItem|null|\yii\rbac\Permission|\yii\rbac\Role
     */
    public function getAuthObject()
    {
        if ($this->authObject == null)
        {
            $am = Yii::$app->authManager;
            if ($this->type == AuthItem::TYPE_PERMISSION)
            {
                $this->authObject = $am->createPermission($this->name);
            }
            elseif ($this->type == AuthItem::TYPE_ROLE)
            {
                $this->authObject = $am->createRole($this->name);
            }
            elseif ($this->type == AuthItem::TYPE_TASK)
            {
                $this->authObject       = new TaskItem();
                $this->authObject->name = $this->name;
            }

            $this->authObject->description = $this->description;
            $this->authObject->ruleName    = $this->rule_name;
            $this->authObject->data        = $this->data;
        }
        return $this->authObject;
    }

    /**
     * create auth object in database
     *
     * @return bool
     * @throws \Exception
     */
    public function createAuthItem()
    {
        $authManager = Yii::$app->authManager;
        $toAdd       = $this->getAuthObject();
        return $authManager->add($toAdd);
    }


    /**
     * {@inheritdoc}
     * @return \common\models\queries\AuthItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        /** @var $retVal \common\models\auth\queries\AuthItemQuery */
        $retVal = new AuthItemQuery(get_called_class());
        return $retVal;
    }

    /**
     * @param $parentType
     * @param $givenTypes
     *
     * @throws PermissionException
     */
    public static function checkTypeIntegrity($parentType, $givenTypes)
    {

        $allowedTypes = self::getAllowedTypesForAssignment($parentType);

        foreach ($givenTypes as $givenType)
        {
            // check if all given types are allowed
            if (!(in_array($givenType, $allowedTypes)))
            {
                $parentTypeName = AuthItem::getTypeNameS($parentType);
                throw new PermissionException("type list [" . self::getNamesForFilter($givenTypes) . "] contains a type higher than parent's type: $parentTypeName");
            }
        }
    }

    /**
     * @param $type
     *
     * @return array
     */
    public static function getAllowedTypesForAssignment($type)
    {
        $typeList = [];
        if ($type == AuthItem::TYPE_TASK)
        {
            // allowed: Task, Permission
            $typeList = [AuthItem::TYPE_TASK, AuthItem::TYPE_PERMISSION,];

        }
        elseif ($type == AuthItem::TYPE_ROLE)
        {
            // all allowed -> return all types
            $typeList = array_keys(self::getTypeList());
        } // else none allowed -> result list will be empty
        return $typeList;
    }

    /**
     * output Rolle, Recht, Aufgabe
     *
     * @param $typeFilter
     *
     * @return string
     */
    private static function getNamesForFilter($typeFilter)
    {
        $result = [];
        foreach ($typeFilter as $type)
        {
            $result [] = AuthItem::getTypeNameS($type);
        }
        return implode(',', $result);
    }

    /**
     * checks if this object has any children assigned to
     * @return bool
     */
    public function hasChildren()
    {
        $children = Yii::$app->authManager->getChildren($this->name);
        return 0 < count($children);
    }

    /**
     * returns if the current object is role AuthItem::SUPER_ADMIN_ROLE
     * @return bool
     */
    public function isAdminRole()
    {
        return $this->type == self::TYPE_ROLE && $this->name == AuthItem::SUPER_ADMIN_ROLE;
    }

    /**
     * returns if the current object is the permission AuthItem::SUPER_PERMISSION
     * @return bool
     */
    public function isSuperPermission()
    {
        return $this->type == self::TYPE_PERMISSION && $this->name == AuthItem::SUPER_PERMISSION;
    }

    /**
     * Returns a List of all available Roles
     * @return array
     */
    public static function getRoleList(){
        return yii\helpers\ArrayHelper::map(Yii::$app->authManager->getRoles(), 'name', 'name');
    }
}
