<?php
/**
 * @link http://www.euqol.com/
 * @copyright Copyright (c) 2015 Su Anli
 * @license http://www.euqol.com/license/
 */

namespace anli\auth0\models;

use Yii;

/**
 * This is the model class for table "{{%tenant}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $created_at
 * @property integer $create_user_id
 * @property string $updated_at
 * @property integer $update_user_id
 *
 * @property TenantUser[] $tenantUsers
 *
 * @author Su Anli <anli@euqol.com>
 * @since 1.0.0
 */
class Tenant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%tenant}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['create_user_id', 'update_user_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'created_at' => 'Created At',
            'create_user_id' => 'Create User ID',
            'updated_at' => 'Updated At',
            'update_user_id' => 'Update User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantUsers()
    {
        return $this->hasMany(TenantUser::className(), ['tenant_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TenantQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TenantQuery(get_called_class());
    }

    /**
     * Finds tenant by auth0 authenticated user first tenant name for the current service.
     * Create a tenant if it does not exists.
     *
     * @return mixed
     */
    public static function findByAuth0()
    {
        $query = self::find()
        ->andWhere(['name' => Yii::$app->getModule('auth0')->auth0->getDefaultTenant()]);

        if (!$query->exists()) {
            $model = new Tenant;
            $model->name = Yii::$app->getModule('auth0')->auth0->getDefaultTenant();
            $model->save();
            $model->refresh();

            return $model;
        }

        return $query->one();
    }

    /**
     * @return array
     */
    public static function column()
    {
        return new TenantColumn(get_called_class());
    }
}
