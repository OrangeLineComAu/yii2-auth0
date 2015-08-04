<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use Yii;

/**
 * This is the user controller class.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class UserController extends \yii\web\Controller
{
    /**
     * Login a user with auth0
     * @return mixed
     */
    public function actionLogin()
    {
        $auth0 = $this->module->auth0;
        $userInfo = $auth0->getUser();

        if ($userInfo) {
            return 'Login successful';
        }

        return $this->render('login', [
            'module' => $this->module,
        ]);
    }
}
