<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Auth0\SDK\API\ApiUsers;
use Yii;

/**
 * This is the query class for [[ApiUser]].
 *
 * @see ApiUser
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUserQuery
{
    /**
     * @var array
     */
    public $params = [
        'q' => '',
        'search_engine' => 'v2',
    ];

    /**
     * @return ApiUsers[]|array
     */
    public function all()
    {
        return ApiUsers::search(Yii::$app->getModule('auth0')->domain, Yii::$app->getModule('auth0')->apiTokens['usersRead'], $this->params);
    }

    /**
     * @return mixed
     */
    public function service()
    {
        $serviceId = Yii::$app->getModule('auth0')->serviceId;

        $this->params['q'] = "_exists_:app_metadata.permissions.{$serviceId}";
        return $this;
    }

    /**
     * @return mixed
     */
    public function tenant()
    {
        $serviceId = Yii::$app->getModule('auth0')->serviceId;
        $tenant = str_replace(' ', '\\ ', Yii::$app->tenant->identity->name);

        $this->params['q'] = "_exists_:app_metadata.permissions.{$serviceId}.{$tenant}";
        return $this;
    }

    /**
     * @return mixed
     */
    public function orderBy($order)
    {
        $this->params['sort'] = $order;
        return $this;
    }
}
