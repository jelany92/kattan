<?php

namespace backend\controllers;

use backend\models\ForgotPasswordForm;
use common\controller\BaseController;
use common\models\AdminUser;
use common\models\AdminUserForm;
use common\models\AdminUserLoginLog;
use common\models\AdminUserRoleLog;
use common\models\auth\AuthItem;
use common\models\search\AdminUserSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

/**
 * AdminUserController implements the CRUD actions for AdminUser model.
 */
class AdminUserController extends BaseController
{
    /**
     * Lists all AdminUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new AdminUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AdminUser model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);

        $loginProvider = new ActiveDataProvider([
            'query'      => AdminUserLoginLog::find()->user($model)->limit(Yii::$app->params['smallPageSize']),
            'pagination' => false,
            'sort'       => ['defaultOrder' => ['login_at' => SORT_DESC,],],
        ]);

        $roleProvider = new ActiveDataProvider([
            'query'      => AdminUserRoleLog::find()->user($model)->limit(Yii::$app->params['smallPageSize']),
            'pagination' => false,
            'sort'       => ['defaultOrder' => ['modified_at' => SORT_DESC,],],
        ]);

        return $this->render('view', [
            'model'         => $model,
            'role'          => $model->getRole(),
            'loginProvider' => $loginProvider,
            'roleProvider'  => $roleProvider,
        ]);
    }

    /**
     * Updates an existing AdminUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionUpdate($id)
    {
        // DB model
        $dbUserModel = $this->findModel($id);
        // fill formModel
        $formModel              = new AdminUserForm(['scenario' => AdminUserForm::SCENARIO_UPDATE]);
        $formModel->isNewRecord = false;
        $formModel->setAttributes($dbUserModel->attributes);
        // we are in update mode -> there must be a role
        // been assigned during creation of the user
        $formModel->role = $dbUserModel->getRole();
        // adjust to format defined as rule in AdminUserForm
        $formModel->adjustActiveFrom($dbUserModel->active_from);
        $formModel->adjustActiveUntil($dbUserModel->active_until);
        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate())
        {
            $dbUserModel->scenario = AdminUser::SCENARIO_UPDATE;
            $transaction           = Yii::$app->db->beginTransaction();
            try
            {
                $oldRole = $dbUserModel->role;
                $dbUserModel->setAttributes($formModel->attributes);
                if ($dbUserModel->save())
                {
                    $dbUserModel->checkAndWriteAssignment($formModel->role, $oldRole);
                }
                else
                {
                    throw new \Exception("Benutzer $dbUserModel->username konnte nicht gespeichert werden");
                }
                $transaction->commit();
            } catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
            Yii::$app->session->addFlash('success', Yii::t('app', 'Benutzer wurde aktualisiert'));
            return $this->redirect([
                'view',
                'id' => $dbUserModel->id,
            ]);
        }

        return $this->render('update', [
            'formModel' => $formModel,
            'roleList'  => AuthItem::getRoleList(),
            'id'        => $dbUserModel->id,
        ]);
    }

    /**
     * Creates a new AdminUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @return mixed
     */
    public function actionCreate()
    {
        $formModel = new AdminUserForm(['scenario' => AdminUserForm::SCENARIO_REGISTER]);

        if ($formModel->load(Yii::$app->request->post()) && $formModel->validate())
        {
            $dbUserModel           = new AdminUser();
            $dbUserModel->scenario = AdminUser::SCENARIO_REGISTER;
            $transaction           = Yii::$app->db->beginTransaction();
            try
            {
                $dbUserModel->setAttributes($formModel->attributes);
                if ($dbUserModel->save())
                {
                    $dbUserModel->checkAndWriteAssignment($formModel->role);
                }
                else
                {
                    throw new \Exception("Benutzer $dbUserModel->username konnte nicht gespeichert werden");
                }

                $transaction->commit();
                Yii::$app->session->addFlash('success', Yii::t('app', 'Neuer Benutzer wurde erstellt'));
                return $this->redirect([
                    'view',
                    'id' => $dbUserModel->id,
                ]);
            } catch (\Exception $e)
            {
                $transaction->rollBack();
                throw $e;
            }
        }
        return $this->render('create', [
            'formModel' => $formModel,
            'roleList'  => AuthItem::getRoleList(),
        ]);
    }

    /**
     * Activates an AdminUser instance and overwrites the active_from date.
     *
     * @param $id AdminUser id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        try
        {
            if (Yii::$app->user->id == $model->id)
            {
                throw new \Exception('Benutzer darf sich nicht selbst aktivieren');
            }
            if (!$model->isActive())
            {
                $model->activate();


                Yii::$app->session->addFlash('success', Yii::t('app', 'Benutzer wurde aktiviert'));
            }
        } catch (\Exception $e)
        {
            Yii::$app->session->addFlash('error', $e->getMessage());
        }
        return $this->redirect([
            'view',
            'id' => $model->id,
        ]);

    }

    /**
     * delete an AdminUser
     *
     * @param $id
     *
     * @return \yii\web\Response
     * @throws \Throwable
     * @throws \yii\db\Exception
     */
    public function actionDelete($id)
    {
        // more than one table is involved
        $transaction = Yii::$app->db->beginTransaction();
        try
        {
            $adminUser = $this->findModel($id);
            if (Yii::$app->user->id == $adminUser->id)
            {
                throw new \Exception('Benutzer darf sich nicht selbst löschen');
            }
            // delete entries in admin_user_login_log
            AdminUserLoginLog::deleteAll(['user_id' => $adminUser->id]);
            // delete entries in admin_user_role_log
            AdminUserRoleLog::deleteAll(['user_id' => $adminUser->id]);
            Yii::$app->authManager->revokeAll($adminUser->id);
            // finally: delete user in admin_user
            $adminUser->delete();
            $transaction->commit();
            Yii::$app->session->addFlash('success', Yii::t('app', 'Benutzer wurde erfolgreich gelöscht'));
        } catch (\Exception $e)
        {
            $transaction->rollBack();
            Yii::$app->session->addFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * deactivates an AdminUser
     *
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeactivate($id)
    {
        $userModel = $this->findModel($id); // get AdminUser model
        $userModel->setScenario(AdminUser::SCENARIO_DEACTIVATE);
        try
        {
            if (Yii::$app->user->id == $userModel->id)
            {
                throw new \Exception('Benutzer darf sich nicht selbst deaktivieren');
            }

            if ($userModel->isActive())
            {
                // set password = passwordresettoken = activeFrom to null
                $userModel->setAttribute('active_from', null);
                $userModel->setAttribute('password', null);
                $userModel->setAttribute('password_reset_token', null);
                if ($userModel->validate())
                {
                    $userModel->save();
                    Yii::$app->session->addFlash('success', Yii::t('app', 'Benutzer wurde deaktiviert'));
                }
                else
                {
                    throw new \Exception(Yii::t('app', "Validierungsfehler: $userModel->errors"));
                }
            }
            else
            {
                throw new \Exception(Yii::t('app', "Benutzer ist nicht aktiviert"));
            }
        } catch (\Exception $e)
        {
            Yii::$app->session->addFlash('error', Yii::t('app', "Deaktivierung fehlgeschlagen: " . $e->getMessage()));
        }
        return $this->redirect([
            'view',
            'id' => $userModel->id,
        ]);
    }

    /**
     * sends mail to user after clicking 'forgot password'
     *
     * @param $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionForgotPassword($id)
    {
        $model = $this->findModel($id);
        if ($model->isActive())
        {
            $model->setForgotPasswordToken();
            $form = new ForgotPasswordForm();
            $form->sendForgotPasswordMail($model);

            Yii::$app->session->addFlash('success', Yii::t('app', 'Neues Passwort wurde angefordert'));
            return $this->redirect([
                'view',
                'id' => $model->id,
            ]);
        }
    }

    /**
     * Finds the AdminUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return AdminUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AdminUser::findOne($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'Seite exisitiert nicht'));
    }
}
