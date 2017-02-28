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
 * This is the controller class for the User model.
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
        // Open session before accessing auth0
        // to ensure Yii session is initialised
        // which configures the native PHP settings
        // (session_name(), $_SESSION object)
        Yii::$app->session->open();

        $this->layout = $this->module->layout;
        Yii::trace("in actionLogin",  __METHOD__);
        $model = new LoginForm;

        $auth0 = $this->module->auth0;

        $return = Yii::$app->user->getReturnUrl();

        if ($auth0->getUser() && $auth0->validate()) {
            $model->login();
            Yii::trace($_SESSION,  __METHOD__);
            return  $this->goBack($return);// $this->goBack();
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
        // Open session before accessing auth0
        // to ensure Yii session is initialised
        // which configures the native PHP settings
        // (session_name(), $_SESSION object)
        Yii::$app->session->open();

        $this->module->auth0->logout();
        Yii::$app->user->logout();
        //session_destroy();
        return $this->goHome();
    }
}
