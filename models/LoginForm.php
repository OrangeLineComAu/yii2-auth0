<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;
use yii\base\Model;

/**
 * This is the class for Login Form.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class LoginForm extends Model
{
    /**
     * @var mixed
     */
    private $_user = false;

    /**
     * @var mixed
     */
    private $_tenant = false;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
      Yii::trace("login in LoginForm",  __METHOD__);
      Yii::$app->user->login($this->getUser(),60 * 60 * 24 * 7);
      Yii::$app->tenant->login($this->getTenant());
      return true; 
    }


    /**
     * Finds user by auth0 authenticated user
     *
     * @return User|null
     */
    public function getUser()
    {
        $auth0Data = Yii::$app->getModule('auth0')->auth0->getUser();

        if ($this->_user === false) {
            $this->_user = User::findByAuth0($auth0Data);
        }

        return $this->_user;
    }

    /**
     * Finds tenant by auth0 authenticated user app metadata
     *
     * @return User|null
     */
    public function getTenant()
    {
        if ($this->_tenant === false) {
            $this->_tenant = Tenant::findByAuth0();
        }

        return $this->_tenant;
    }
}
