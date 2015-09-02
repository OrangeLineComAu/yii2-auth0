<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * This is the class for Login Form.
 * @author Su Anli <anli@euqol.com>
 * @since 1.6.0
 */
class TenantLoginForm extends Model
{
    /**
     * @var integer
     */
    public $tenant_id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenant_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tenant_id' => 'Tenant',
        ];
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return array
     */
    public function getTenantSelect2Data()
    {
        $array = Tenant::find()
            ->select(['{{%tenant}}.id', '{{%tenant}}.name'])
            ->byUser()
            ->asArray()
            ->all();

        return ArrayHelper::map($array,'id', 'name');
    }

    /**
     * @return boolean Return true if login is successful
     */
    public function login()
    {
        $auth0 = Yii::$app->getModule('auth0')->getAuth0();

        if ($auth0->validateTenant($this->tenant->name)) {
            Yii::$app->tenant->login($this->tenant);
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function getTenant()
    {
        return Tenant::findOne($this->tenant_id);
    }
}
