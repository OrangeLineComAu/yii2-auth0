<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\controllers;

use anli\auth0\models\ApiUser;
use Yii;

/**
 * This is the ServiceAdmin controller class for Auth0.
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ServiceAdminController extends \yii\web\Controller
{
    /**
     * See all users by service
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'query' => ApiUser::find()->orderBy('email:1'),
        ]);
    }
}
