<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use anli\auth0\models\Tenant;
use anli\auth0\models\User;
use anli\auth0\models\TenantUser;
use anli\auth0\models\ApiUser;
use Auth0\SDK\API\ApiUsers;
use Yii;
use yii\web\HttpException;
use yii\filters\AccessControl;

/**
 * This is the controller class for the API User model.
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUserController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'update-role', 'remove-tenant', 'update',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->controller->module->isAdmin;
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * @param string $userId
     * @param string $role
     * @param string $tenantId
     * @return mixed
     */
    public function actionUpdateRole($userId, $role = 'user', $tenantId = null)
    {
        if (!isset($tenantId)) {
            $tenant = Yii::$app->tenant->identity;
        } else {
            $tenant = Tenant::findOne($tenantId);
        }

        //return print_r($tenant->name);
        $model = ApiUser::findOne($userId);

        $data = [
            'app_metadata' => ['permissions' => [
                    Yii::$app->getModule('auth0')->serviceId => [
                        $tenant->name => ['role' => $role],
                    ],
            ],],
        ];

        if ($model) {
            if (isset($model['app_metadata'])) {

                if ($this->update($userId, array_replace_recursive(['app_metadata' => $model['app_metadata']], $data))) {
                    $user = User::findByAuth0($model);
                    $tenantUser = TenantUser::findByTenantUser($tenant, $user);

                    $msg = 'Successful updated a role';
                    return $this->goBack();
                }
                throw new HttpException(400, 'Updating of role has failed.');
            }

            if ($this->update($userId, $data)) {
                $user = User::findByAuth0($model);
                $tenantUser = TenantUser::findByTenantUser($tenant, $user);

                $msg = 'Successfully added a role';
                return $this->goBack();
            }
            throw new HttpException(400, 'Adding of role has failed.');
        }

        throw new HttpException(404, 'The requested user cannot be found.');
    }

    /**
     * @param string $userId
     * @return mixed
     */
    public function actionRemoveTenant($userId, $tenantId = null)
    {
        if (!isset($tenantId)) {
            $tenant = Yii::$app->tenant->identity;
        } else {
            $tenant = Tenant::findOne($tenantId);
        }

        $model = ApiUser::findOne($userId);

        if ($model) {
            $data = ['app_metadata' => $model['app_metadata']];
            unset($data['app_metadata']['permissions'][Yii::$app->getModule('auth0')->serviceId][$tenant->name]);

            if ($this->update($userId, $data)) {
                $user = User::findByAuth0($model);
                $tenantUser = TenantUser::findByTenantUser($tenant, $user);
                $tenantUser->delete();

                $msg = 'Successfully removed the selected user from the current tenant';
                return $this->goBack();
            };
        }

        throw new HttpException(404, 'The requested user cannot be found.');
    }

    /**
     * @param string $userId
     * @param string $data
     * @return mixed
     */
    protected function update($userId, $data)
    {
        return ApiUsers::update(Yii::$app->getModule('auth0')->domain, Yii::$app->getModule('auth0')->apiTokens['usersUpdate'], $userId, $data);
    }

}
