<?php

namespace app\models;

use Yii;
use \yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property string $auth_key
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $secret_key
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const STATUS_NOT_ACTIVE = 1;
    public $password = '';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'status'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            ['email', 'email'],
            ['password', 'required', 'on' => 'create'],
            ['username', 'unique', 'message' => '��� ��� ������'],
            ['email', 'unique', 'message' => '��� ����� ��� ����������������']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'auth_key' => 'Auth Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'secret_key' => 'Secret Key',
        ];
    }
    /*
     * ���������
     */
    public function behaviours()
    {
        return [
            TimestampBehavior::className()
        ];
    }
    /*
     * �����
     */
    public static function findByUsername($username)
    {
        return static::findOne([
            'username' => $username
        ]);
    }
    /*
     * �������
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function validatePassword($password)
    {

        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /*
     * �������������� ������������
     */

    /*
     * ����� ������������ �� id c �������� ��������
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /*
     * ����� ������������ �� ����� �������
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * ���������� id ����� ������������
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * ���������� ���� ������������ ��� ��������� ����� cookie
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * ���������� ���� ���������� �� cookie ������� � ������ �� �������
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert) {
        if ($this->password) {
            $this->setPassword($this->password);
        }
        return parent::beforeSave($insert);
    }
}