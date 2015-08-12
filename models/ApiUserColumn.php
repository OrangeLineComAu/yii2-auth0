<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;

/**
 * This is the column class for [[ApiUser]].
 *
 * @see ApiUser
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class ApiUserColumn
{
    const CONTROLLER = 'api-user';

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

    /**
     * @return mixed
     */
    public function userId()
    {
        $this->columns = array_merge($this->columns, ['user_id']);
        return $this;
    }

    /**
     * @return string $template
     * @return mixed
     */
    public function actions($template = '{update} {delete}')
    {
        $this->columns = array_merge($this->columns, [
            [
                'header' => 'actions',
                'class' => ActionColumn::className(),
                'controller' => SELF::CONTROLLER,
                'template' => $template,
                'buttons' => [
                    'update-role-to-user' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-check"></i>', [SELF::CONTROLLER . '/update-role', 'userId' => $model['user_id'], 'role' => 'user'], [
                            'title' => 'Add',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                    'remove-tenant' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-times"></i>', [SELF::CONTROLLER . '/remove-tenant', 'userId' => $model['user_id']], [
                            'title' => 'Remove',
                            'data-toggle' => 'tooltip',
                        ]);
                    },
                ],
            ]
        ]);
        return $this;
    }
}
