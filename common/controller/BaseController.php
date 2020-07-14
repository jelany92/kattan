<?php
namespace common\controller;

use Yii;

class BaseController extends \yii\web\Controller
{
    
    public function beforeAction($action)
    {
        $retVal = false;
        if (Yii::$app->user->isGuest)
        {
            Yii::$app->session->addFlash('error', Yii::t('app', 'Benutzer ist nicht angemeldet'));
            return $this->goHome();
        }

        if (!parent::beforeAction($action))
        {
            return $retVal;
        }
        // get current action
        $action     = Yii::$app->controller->action->id;
        $controller = Yii::$app->controller->id;
        $user       = Yii::$app->user->identity->username;

        // check if authorized for action

        $retVal = Yii::$app->user->can("$controller.$action");
        if (!$retVal)
        {
            $msg = Yii::t('app', "Aktion $controller.$action ist nicht zulässig für Benutzer $user");
            Yii::$app->session->addFlash('error', Yii::t('app', $msg));
            throw new \Exception($msg);

        }

        $retString = $retVal ? "O.K." : "--- NOT ALLOWED ---";
        yii::info("USER $user may execute the ACTION = $action: $retString", __METHOD__);
        return $retVal;
    }

}