<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

/**
 * This is the ActiveQuery class for [[TenantUser]].
 *
 * @see TenantUser
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class TenantUserQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return TenantUser[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TenantUser|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
