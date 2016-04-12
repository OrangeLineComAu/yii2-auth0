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
 * This is the model class for Auth0 Api Users".
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUser extends \yii\base\Model
{
    /**
     * @var mixed
     */
    public $apiUsers;

    /**
     * @inheritdoc
     */
    public function init()
    {
       parent::init();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public static function find()
    {
        return new ApiUserQuery(get_called_class());
    }

    /**
     * @return array
     */
    public static function column()
    {
        return new ApiUserColumn(get_called_class());
    }

    /**
     * @param string $userId
     * @return mixed
     */
    public function findOne($userId)
    {
        if ('' != $userId) {
            return ApiUsers::get(Yii::$app->getModule('auth0')->domain, Yii::$app->getModule('auth0')->apiTokens['usersRead'], $userId);
        }

        return false;
    }
}
