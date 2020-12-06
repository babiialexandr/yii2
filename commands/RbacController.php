<?php

namespace app\commands;

use yii\console\Controller;
use Yii;
use Exception;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->getAuthManager();
        $auth->removeAll();

        $userRole = $auth->createRole('user');
        $auth->add($userRole);

        $adminRole = $auth->createRole('admin');
        $auth->add($adminRole);
        $auth->addChild($adminRole, $userRole);

        $manageSystem = $auth->createPermission('manageSystem');
        $manageSystem->description = 'access system management';
        $auth->add($manageSystem);
        $auth->addChild($adminRole, $manageSystem);

        $auth->assign($adminRole, 9);

    }
}
