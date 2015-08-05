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
 * This is the model class for user login.
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
        Yii::$app->user->login($this->getUser());
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
        if ($this->_user === false) {
            $this->_user = User::findByAuth0();
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
