<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;

/**
 * This is the column class for [[ApiUser]].
 *
 * @see ApiUser
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUserColumn
{
    /**
     * @var array
     */
    public $columns = [];

    /**
     * @return array
     */
    public function all()
    {
        return $this->columns;
    }

    /**
     * @return mixed
     */
    public function nickname()
    {
        $this->columns = array_merge($this->columns, ['nickname']);
        return $this;
    }

    /**
     * @return mixed
     */
    public function email()
    {
        $this->columns = array_merge($this->columns, ['email']);
        return $this;
    }

    /**
     * @return mixed
     */
    public function role()
    {
        $this->columns = array_merge($this->columns, [
            [
                'label' => 'Role',
                'value' => function ($model, $key, $index, $column) {
                    if (isset($model['app_metadata']['permissions'][Yii::$app->getModule('auth0')->serviceId][Yii::$app->tenant->identity->name]['role'])) {

                        return $model['app_metadata']['permissions'][Yii::$app->getModule('auth0')->serviceId][Yii::$app->tenant->identity->name]['role'];
                    }
                    return '';
                }
            ]
        ]);
        return $this;
    }
}
