<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "launch".
 *
 * @property string email
 * @property numeric id
 * @property string userName
 * @property integer accessToken
 * @property integer password
 */
class Users extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['email', 'userName', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique', 'message' => 'This email is already exists'],
            ['userName', 'unique', 'message' => 'This user is already exists'],
            [['userName', 'email'], 'trim'],
            'password' => [['password'], 'string', 'max' => 65, 'min' => 8],

        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }


    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['accessToken' => $token]);
    }

    public function findIdentityByGoogleToken($token, $type = null)
    {
        return static::findOne(['googleToken' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getAuthKey()
    {
        return $this->accessToken;
    }

    public function validateAuthKey($authKey)
    {
        return true;
    }
}