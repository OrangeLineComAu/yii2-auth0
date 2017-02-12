<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use anli\auth0\models\ApiUser;
use anli\auth0\models\Tenant;
use Yii;
use yii\filters\AccessControl;

/**
 * This is the ServiceAdmin controller class for Auth0.
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ServiceAdminController extends \yii\web\Controller
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
                            'index',
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
     * See all users by service
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->user->setReturnUrl(['/' . $this->getRoute()]);

        $userQuery = ApiUser::find()->orderBy('email:1');
        $tenantQuery = Tenant::find()->orderBy('name');

        return $this->render('index', [
            'userQuery' => $userQuery,
            'tenantQuery' => $tenantQuery,
        ]);
    }
}
