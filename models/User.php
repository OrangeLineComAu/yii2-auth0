<?php
namespace anli\auth0\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by auth0 authenticated user
     *
     * @return mixed Return null if no matching record
     */
    public static function findByAuth0($auth0Data)
    {
        $query = self::find()
        ->joinWith('auth')
        ->andWhere(['source_id' => $auth0Data['user_id']])
        ->andWhere(['source' => 'auth0']);

        if (!$query->exists()) {
            return self::createFromAuth0($auth0Data);
        }

        return $query->one();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuth()
    {
        return $this->hasOne(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return $mixed Return false on error
     */
    public static function createFromAuth0($auth0Data)
    {
        // check is email taken

        $query = User::find()
        ->andWhere(['email' => $auth0Data['email']]);

        if ($query->exists()) {
            $model = $query->one();

            $auth = new Auth([
                'user_id' => $model->id,
                'source' => 'auth0',
                'source_id' => (string)$auth0Data['user_id'],
            ]);
            if ($auth->save()) {
                return $model;
            }

            print_r($auth->getErrors());
            return false;

        } else {
            $model = new self([
                'username' => $auth0Data['nickname'],
                'email' => $auth0Data['email'],
                'password' => Yii::$app->security->generateRandomString(6),
            ]);
            $model->generateAuthKey();
            $model->generatePasswordResetToken();
            $transaction = $model->getDb()->beginTransaction();
            if ($model->save()) {
                $auth = new Auth([
                    'user_id' => $model->id,
                    'source' => 'auth0',
                    'source_id' => (string)$auth0Data['user_id'],
                ]);
                if ($auth->save()) {
                    $transaction->commit();
                    return $model;
                }

                print_r($auth->getErrors());
                return false;
            }

            print_r($user->getErrors());
            return false;
        }
    }

    /**
     * Generate an array for a select2 control.
     * @return array
     */
    public static function select2Data()
    {
      $query = self::find()
      ->joinWith('tenantUsers')
      ->andWhere(['{{%tenant_user}}.tenant_id' => Yii::$app->tenant->identity->id])
      ->select(['{{%user}}.id', 'username'])
      ->orderBy('username');

      $array = $query
      ->asArray()->all();

      return ArrayHelper::map($array,'id', 'username');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTenantUsers()
    {
        return $this->hasMany(TenantUser::className(), ['user_id' => 'id']);
    }

    /**
     * @return mixed
     */
    public static function ByTenant()
    {
      return self::find()
      ->joinWith('tenantUsers')
      ->andWhere(['{{%tenant_user}}.tenant_id' => Yii::$app->tenant->identity->id]);
    }

    /**
     * @inheritdoc
     * @return TimesheetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }
}
