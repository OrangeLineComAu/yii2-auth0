<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;

/**
 * This is the auth0 model class.
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class Auth0 extends \Auth0\SDK\Auth0
{
    /**
     * @return mixed
     */
    public function getAuth()
    {
        return Auth::find()->where([
            'source' => 'auth0',
            'source_id' => $this->getUser()['user_id'],
        ])->one();
    }

    /**
     * @return boolean Return true if user login is successful
     */
    public function loginUser()
    {
        if (Yii::$app->user->isGuest) {

            if ($this->getAuth()) {
                Yii::$app->user->login($this->getAuth()->user);
                return true;
            }

            $this->createUserAndLogin();
        }

        return false;
    }

    /**
     * @return mixed
     */
    protected function createUserAndLogin()
    {
        $user = new User([
            'username' => $this->getUser()['nickname'],
            'email' => $this->getUser()['email'],
            'password' => Yii::$app->security->generateRandomString(6),
        ]);
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $transaction = $user->getDb()->beginTransaction();
        if ($user->save()) {
            $auth = new Auth([
                'user_id' => $user->id,
                'source' => 'auth0',
                'source_id' => (string)$this->getUser()['user_id'],
            ]);
            if ($auth->save()) {
                $transaction->commit();
                Yii::$app->user->login($user);

                return true;
            }

            print_r($auth->getErrors());
            return false;
        }

        print_r($user->getErrors());
        return false;
    }

    /**
     * @param string $name
     * @return boolean Return true if tenant login is successful
     */
    /*public function loginTenant()
    {
        if (!this->getTenant()) {
            $this->createTenant();
        }

        return

        if (!$this->getTenantByName($name)) {
            if ($this->createTenant(['name' => $name])) {
                return $this->getTenantByName($name)->login();
            }
        }

        return $this->getTenantByName($name)->login();
    }*/

    /**
     * @return array
     */
    public function getPermissions()
    {
        return $this->getAppMetadata()['permissions'];
    }

    /**
     * @return array
     */
    public function getServiceIds()
    {
        return array_keys($this->getPermissions());
    }

    /**
     * @return array
     */
    public function getTenants()
    {
        if (isset($this->getPermissions()[$this->getServiceId()])) {
            return array_keys($this->getPermissions()[$this->getServiceId()]);
        }

        return [];
    }
}
