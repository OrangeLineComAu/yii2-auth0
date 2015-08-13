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
}
