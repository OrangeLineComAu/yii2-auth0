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
      if (!session_id()) {
          Yii::trace("Starting session",  __METHOD__);
          session_set_cookie_params(60 * 60 * 24 * 7); //seven days
          session_start();
      }
        $this->layout = '@vendor/anli/yii2-metronic/views/layouts/login';
        Yii::trace("in actionLogin",  __METHOD__);
        $model = new LoginForm;

        $auth0 = $this->module->auth0;
        //Yii::trace($auth0,  __METHOD__);
        //Yii::trace($auth0->getUser(),  __METHOD__);
        //Yii::trace($auth0->validate());

        if ($auth0->getUser() && $auth0->validate()) {
            $model->login();
            Yii::trace($_SESSION,  __METHOD__);
            return  $this->goBack();// $this->goBack();
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
        //session_destroy();
        return $this->goHome();
    }
}
