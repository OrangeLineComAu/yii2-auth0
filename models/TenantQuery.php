<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

/**
 * This is the ActiveQuery class for [[Tenant]].
 *
 * @see Tenant
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class TenantQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return Tenant[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tenant|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
