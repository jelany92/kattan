<?php

namespace common\models;

use common\models\auth\AuthAssignment;
use common\models\auth\AuthItem;
use common\models\traits\TimestampBehaviorTrait;
use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "admin-user".
 *
 * @property int              $id
 * @property string           $username
 * @property string           $first_name
 * @property string           $last_name
 * @property string           $password
 * @property string           $password_reset_token
 * @property string           $email
 * @property string           $active_from
 * @property string           $active_until
 * @property string           $created_at
 * @property string           $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthItem[]       $itemNames
 */
class AdminUser extends ActiveRecord implements IdentityInterface
{
    public $role;
    public $auth_key;

    const SCENARIO_REGISTER        = 'register';
    const SCENARIO_UPDATE          = 'update';
    const SCENARIO_FORGOT_PASSWORD = 'forgot-password';
    const SCENARIO_RESET_PASSWORD  = 'reset-password';
    const SCENARIO_ACTIVATE        = 'activate';
    const SCENARIO_DEACTIVATE      = 'deactivate';

    const MARKET_PROJECT       = 'Market';
    const BOOK_GALLERY_PROJECT = 'Book Gallery';
    const JELANY_BOOK_CATEGORY = 2;
    const YII_LEARN            = 'Yii Learning';

    use TimestampBehaviorTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'admin_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'first_name', 'last_name', 'password', 'email', 'active_from',], 'required', 'except' => self::SCENARIO_DEACTIVATE],
            [['username', 'first_name', 'last_name',], 'string', 'max' => 25,],
            [['password','password_reset_token', 'email',], 'string', 'max' => 255,],
            [['username'], 'unique',],
            [['email'], 'unique',],
            [['email'], 'email',],
            [['active_until', 'active_from',], 'datetime', 'format' => 'yyyy-MM-dd HH:mm',],
            [['password_reset_token'], 'unique',],
            [['active_from', 'active_until', 'created_at', 'updated_at',], 'safe',],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                   => Yii::t('app', 'ID'),
            'username'             => Yii::t('app', 'Benutzername'),
            'first_name'           => Yii::t('app', 'Vorname'),
            'last_name'            => Yii::t('app', 'Nachname'),
            'password'             => Yii::t('app', 'Passwort'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email'                => Yii::t('app', 'E-Mail'),
            'active_from'          => Yii::t('app', 'Aktiv von'),
            'active_until'         => Yii::t('app', 'Aktiv bis'),
            'created_at'           => Yii::t('app', 'Erstellt am'),
            'updated_at'           => Yii::t('app', 'Aktualisiert am'),
        ];
    }

    /**
     * one user may have many adminUserLog entries
     * @return \yii\db\ActiveQuery
     */
    public function getAdminUserLogs()
    {
        return $this->hasMany(AdminUserLog::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::class, ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemNames()
    {
        return $this->hasMany(AuthItem::class, ['name' => 'item_name'])
                    ->viaTable('auth_assignment', ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\queries\AdminUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\queries\AdminUserQuery(get_called_class());
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token))
        {
            return null;
        }

        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token))
        {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire    = Yii::$app->params['user.passwordResetTokenExpire'];
        return time() <= $timestamp + $expire;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     *
     * @throws \yii\base\Exception
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token with timestamp for validation check
     */
    protected function generatePasswordResetToken()
    {
        return Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * @return array of scenarios
     */
    public function scenarios()
    {
        $scenarios                                 = parent::scenarios();
        $scenarios[self::SCENARIO_UPDATE]          = ['username', 'first_name', 'last_name', 'email', 'active_from', 'active_until', ];
        $scenarios[self::SCENARIO_REGISTER]        = ['username', 'first_name', 'last_name', 'email', 'active_from', 'active_until', ];
        $scenarios[self::SCENARIO_FORGOT_PASSWORD] = ['password_reset_token'];
        $scenarios[self::SCENARIO_RESET_PASSWORD]  = ['password_reset_token', 'password', ];
        $scenarios[self::SCENARIO_ACTIVATE]        = ['active_from'];
        $scenarios[self::SCENARIO_DEACTIVATE]      = ['active_from', 'password_reset_token', 'password', ];
        return $scenarios;
    }

    /**
     * @return |null
     */
    public function getRole()
    {
        if ($this->role === null)
        {
            $this->setRole();
        }
        return $this->role;
    }

    /**
     * set role for admin user
     */
    public function setRole()
    {
        $roles = Yii::$app->authManager->getRolesByUser($this->id);
        if (is_array($roles))
        {
            $this->role = key($roles);
        }
    }


    /**
     *  Activates an User
     *
     * @throws \Exception
     */
    public function activate()
    {
        $now = new \DateTime();
        // Ensure that user is active (It is possible to force activation as admin)
        $this->setScenario($this::SCENARIO_ACTIVATE);
        $this->active_from  = $now->format('Y-m-d H:i:s');
        $this->active_until = null;
        $this->save();

        // Send Password set Mail to User
        $this->sendActivationMail();
        // Send Info Mail to all Members of Group "admin"
        $this->sendActivationNotificationMail();
    }

    /**
     * Checks if the current user is active
     *
     * @return bool
     * @throws \Exception
     */
    public function isActive()
    {
        $isActive    = false;
        $now         = new \DateTime();
        $activeFrom  = new \DateTime($this->active_from);
        $activeUntil = new \DateTime($this->active_until);

        if ((!is_null($activeFrom) && $activeFrom < $now) && ((is_null($this->active_until)) || ($now < $activeUntil)) && (!is_null($this->password) || !is_null($this->password_reset_token)))
        {
            $isActive = true;
        }

        return $isActive;
    }

    /**Checks if user has role AuthItem::SUPER_ADMIN_ROLE
     *
     * @param $userId
     *
     * @return bool
     *
     */
    public static function isSuperAdmin($userId)
    {
        $isAdmin  = false;
        $roleList = Yii::$app->authManager->getRolesByUser($userId);
        if (0 < count($roleList))
        {
            $isAdmin = array_key_exists(AuthItem::SUPER_ADMIN_ROLE, $roleList);
        }
        return $isAdmin;
    }

    /**
     * Set Token for password reset function
     */
    public function setForgotPasswordToken()
    {
        $this->setScenario(AdminUser::SCENARIO_FORGOT_PASSWORD);
        $this->password_reset_token = $this->generatePasswordResetToken();
        $this->save();
    }

    /**
     * Creates password reset token and sends an activation mail to the user
     *
     * @return bool
     */
    private function sendActivationMail()
    {
        $this->setForgotPasswordToken();
        return Yii::$app->mailer->compose([
            'html' => 'passwordResetToken-html',
            'text' => 'passwordResetToken-text',
        ], [
            'user'      => $this,
            'resetLink' => Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password','token' => $this->password_reset_token,])
        ])
            ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject(Yii::$app->name . ' ' . Yii::t('app', 'Account Aktivierung'))
            ->send();
    }

    /**
     * Send an notification mail to all SuperAdmins that there was a account activation
     * @return bool
     */
    private function sendActivationNotificationMail()
    {
        $superAdminIds = Yii::$app->authManager->getUserIdsByRole(AuthItem::SUPER_ADMIN_ROLE);
        $dataProvider  = new ActiveDataProvider([
            'query'      => AdminUser::find()
                                     ->active()
                                     ->andWhere([
                                         'in',
                                         'id',
                                         $superAdminIds,
                                     ]),
            'pagination' => false,
        ]);
        $messages      = [];
        foreach ($dataProvider->getModels() AS $user)
        {
            $messages[] = Yii::$app->mailer->compose([
                'html' => 'activationNotification-html',
                'text' => 'activationNotification-text',
            ], ['user' => $this])
                                           ->setFrom([Yii::$app->params['adminEmail'] => Yii::$app->name . ' robot'])
                                           ->setSubject(Yii::$app->name . ' ' . Yii::t('app', 'Benachrichtigung Account Aktivierung'))
                                           ->setTo($user->email);
        }
        if (0 < count($messages))
        {
            return Yii::$app->mailer->sendMultiple($messages);
        }
        return false;
    }

    /**
     * Assigns a role to AdminUser.
     * If AdminUser had already an Role, rhe old one will be removed and an Logentry with the old Role is created
     *
     * @param String      $newRole
     * @param String|null $oldRole
     *
     * @throws \Exception
     */
    public function checkAndWriteAssignment($newRole, $oldRole = null)
    {
        if ($oldRole == null)
        {
            // assign ne role
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($newRole), $this->id);
        }
        elseif ($oldRole != $newRole)
        {
            // create logentry with old role
            $this->createLogEntry($oldRole);
            // remove old role
            Yii::$app->authManager->revoke(Yii::$app->authManager->getRole($oldRole), $this->id);
            // assign ne role
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole($newRole), $this->id);
        }
    }

    /**
     * Creates an Logentry
     *
     * @param $role
     *
     * @throws \Exception
     */
    private function createLogEntry($role){
        // create log Entry
        $adminUserLogModel          = new AdminUserRoleLog();
        $adminUserLogModel->role    = $role;
        $adminUserLogModel->user_id = $this->id;
        if (!$adminUserLogModel->save())
        {
            throw new \Exception('Benutzer konnte nicht im Protokoll gespeichert werden');
        }
    }

}