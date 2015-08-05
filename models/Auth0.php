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
     * @return string
     */
    public function getDefaultTenant()
    {
        return $this->getTenants()[0];
    }

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

    /**
     * @return string
     */
    public static function getServiceId()
    {
        return Yii::$app->getModule('auth0')->serviceId;
    }
}
