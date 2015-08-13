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
use yii\helpers\Url;

/**
 * This is the column class for [[Tenant]].
 *
 * @see Tenant
 * @author Su Anli <anli@euqol.com>
 * @since 1.2.0
 */
class TenantColumn
{
    const CONTROLLER = 'tenant';

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
    public function name()
    {
        $this->columns = array_merge($this->columns, ['name']);
        return $this;
    }

    /**
     * @return mixed
     */
    public function users()
    {
        $this->columns = array_merge($this->columns, [
            [
                'label' => 'Users',
                'value' => function ($model, $key, $index, $column) {
                    $count = $model->getTenantUsers()->count();

                    return ($count > 0) ? Yii::$app->formatter->asDecimal($count, 0) : '' ;
                },
            ],
        ]);
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
                'class' => ActionColumn::className(),
                'controller' => SELF::CONTROLLER,
                'template' => $template,
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-pencil"></i>', false, ['value' => Url::to([SELF::CONTROLLER . '/update', 'id' => $model->id]), 'title' => 'Update Tenant', 'class' => 'showModalButton']);
                    },
                ],
                'contentOptions' => ['class' => 'text-right'],
            ]
        ]);
        return $this;
    }

    /**
     * @return mixed
     */
    public function nameWithLink()
    {
        $this->columns = array_merge($this->columns, [
            [
                'attribute' => 'name',
                'value' => function ($model, $key, $index, $column) {
                    return Html::a(Html::encode($model->name), [SELF::CONTROLLER . '/view', 'id' => $model->id]);
                },
                'format' => 'raw',
            ],
        ]);
        return $this;
    }
}
