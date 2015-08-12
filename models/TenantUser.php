<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;

/**
 * This is the model class for table "{{%tenant_user}}".
 *
 * @property integer $id
 * @property integer $tenant_id
 * @property integer $user_id
 * @property string $created_at
 * @property integer $create_user_id
 * @property string $updated_at
 * @property integer $update_user_id
 *
 * @property Tenant $tenant
 * @property User $user
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.1.0
 */
class TenantUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tenant_user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenant_id', 'user_id'], 'required'],
            [['tenant_id', 'user_id', 'create_user_id', 'update_user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tenant_id' => 'Tenant ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'create_user_id' => 'Create User ID',
            'updated_at' => 'Updated At',
            'update_user_id' => 'Update User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenant()
    {
        return $this->hasOne(Tenant::className(), ['id' => 'tenant_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @inheritdoc
     * @return TenantUserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TenantUserQuery(get_called_class());
    }

    /**
     * Finds tenant by user and tenant model
     * Create a tenant if it does not exists.
     *
     * @return mixed
     */
    public static function findByTenantUser($tenant, $user)
    {
        $query = self::find()
        ->andWhere(['tenant_id' => $tenant->id])
        ->andWhere(['user_id' => $user->id]);

        if (!$query->exists()) {
            $model = new TenantUser;
            $model->user_id = $user->id;
            $model->tenant_id = $tenant->id;
            $model->save();
            $model->refresh();

            return $model;
        }

        return $query->one();
    }
}
