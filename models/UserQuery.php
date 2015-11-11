<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 * @author Su Anli <anli@euqol.com>
 * @since 1.7.0
 */
class UserQuery extends \yii\db\ActiveQuery
{
    /**
     * @var string
     */
    protected $tableName = '{{%user}}';

    /**
     * @inheritdoc
     * @return Timesheet[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Timesheet|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @return mixed
     */
    public function byTenant()
    {
        return $this->joinWith('tenantUsers')
            ->andWhere(['{{%tenant_user}}.tenant_id' => Yii::$app->tenant->identity->id]);
    }

    /**
     * @return mixed
     */
    public function hasAuth()
    {
        return $this->joinWith('auth')
        ->andWhere('{{%auth}}.id IS NOT NULL');
    }
}
