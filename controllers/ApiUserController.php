<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use anli\auth0\models\ApiUser;
use Auth0\SDK\API\ApiUsers;
use Yii;
use yii\web\HttpException;

/**
 * This is the controller class for the API User model.
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUserController extends \yii\web\Controller
{
    /**
     * @param string $userId
     * @param string $role
     * @return mixed
     */
    public function actionUpdateRole($userId, $role = 'user')
    {
        $model = ApiUser::findOne($userId);

        $data = [
            'app_metadata' => ['permissions' => [
                    Yii::$app->getModule('auth0')->serviceId => [
                        Yii::$app->tenant->identity->name => ['role' => $role],
                    ],
            ],],
        ];

        if ($model) {
            if (isset($model['app_metadata'])) {

                if ($this->update($userId, array_replace_recursive(['app_metadata' => $model['app_metadata']], $data))) {

                    $msg = 'Successful updated a role';
                    return $this->goBack();
                }
                throw new HttpException(400, 'Updating of role has failed.');
            }

            if ($this->update($userId, $data)) {

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
    public function actionRemoveTenant($userId)
    {
        $model = ApiUser::findOne($userId);

        if ($model) {
            $data = ['app_metadata' => $model['app_metadata']];
            unset($data['app_metadata']['permissions']['customer']['Spark Web Pte Ltd']);

            if ($this->update($userId, $data)) {
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
