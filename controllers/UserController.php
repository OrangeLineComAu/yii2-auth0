<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use anli\auth0\models\LoginForm;
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
        $model = new LoginForm;

        $auth0 = $this->module->auth0;

        if ($auth0->getUser()) {

            $model->login();
            return $this->goHome();
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout a user with auth0
     * @return mixed
     */
    public function actionLogout()
    {
        $this->module->auth0->logout();
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
