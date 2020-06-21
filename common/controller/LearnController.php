<?php

namespace common\controller;

use common\exceptions\PermissionException;
use yii\helpers\Url;
use yii;

class LearnController extends \yii\web\Controller
{
    private $roleList;

    /**
     * List of actions on which to store the current url in the Session for later
     *
     * @return array
     */
    public function actionsToRemember()
    {
        return [];
    }

    public function afterAction($action, $result)
    {
        $this->layout = 'mainLearn';
        if(in_array($action->id, $this->actionsToRemember()))
        {
            Url::remember();
        }
        return parent::afterAction($action, $result);
    }

    public function beforeAction($action)
    {
        $retVal = true;
        if (Yii::$app->user->isGuest)
        {
            Yii::$app->session->addFlash('error', Yii::t('app', 'Benutzer ist nicht angemeldet'));
            return $this->goHome();
        }

        /*if (!parent::beforeAction($action))
        {
            return $retVal;
        }
        // get current action
        $action     = \Yii::$app->controller->action->id;
        $controller = \Yii::$app->controller->id;
        $user       = \Yii::$app->user->identity->username;

        // check if authorized for action

        $retVal = \Yii::$app->user->can("$controller.$action");

        if (!$retVal)
        {
            $msg = $this->buildPermissionErrorMessage($action, $controller, $user);
            Yii::$app->session->addFlash('error', Yii::t('app', $msg));
            throw new PermissionException($msg);
        }*/

        //$retString = $retVal ? "O.K." : "--- NOT ALLOWED ---";
        //yii::info("USER $user may execute the ACTION = $action: $retString", __METHOD__);
        $this->layout = 'mainLearn';

        return $retVal;
    }

    public function buildPermissionErrorMessage($action = null, $controller = null, $user = null)
    {
        $action     = $action ?? \Yii::$app->controller->action->id;
        $controller = $controller ?? \Yii::$app->controller->id;
        $user       = $user ?? \Yii::$app->user->identity->username;

        return Yii::t('app', "Aktion {full_action} ist nicht zulässig für Benutzer {user}", [
            'full_action' => $controller . '.' . $action,
            'user'        => $user,
        ]);
    }
}