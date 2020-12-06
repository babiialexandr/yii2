<?php
namespace app\listeners;

use app\models\User;
use dektrium\user\events\FormEvent;
use dektrium\user\events\UserEvent;
use Yii;
use yii\web\NotFoundHttpException;

class UserListener
{
    /**
     * @param FormEvent $event
     * @throws \Exception
     */
    public static function registerAssignRole(FormEvent $event)
    {
        $auth = Yii::$app->authManager;
        $form = $event->getForm();
        $user = User::findOne(['email' => $form->email]);
        if (!isset($user)) {
            throw new NotFoundHttpException("The user was not found.");
        }
        $auth->revokeAll($user->getId());
        $auth->assign($auth->getRole(User::$mapRoles[$user->role]), $user->getId());
    }

    /**
     * @param UserEvent $event
     * @throws \Exception
     */
    public static function adminAssignRole(UserEvent $event)
    {
        $auth = Yii::$app->authManager;
        $user = $event->getUser();
        $auth->revokeAll($user->getId());
        $auth->assign($auth->getRole(User::$mapRoles[$user->role]), $user->getId());
    }
}
