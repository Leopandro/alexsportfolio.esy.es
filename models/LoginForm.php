<?php

namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $email;
    public $rememberMe;
    public $status;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'],'required', 'on' => 'default'],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['username', 'validateUser'],
            ['password', 'validatePassword']
        ];
    }

    public function validateUser($attribute)
    {
        if (!$user = $this->getUser())
        {
            $this->addError($attribute, 'Такого пользователя не существует');
        }
    }

    public function validatePassword($attribute)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password))
            {
                $this->addError($attribute, 'Вы ввели неправильный пароль');
            }
        }
    }

    public function getUser()
    {
        if ($this->_user === false)
        {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня'
        ];
    }

    public function login()
    {
        if ($this->validate())
        {
            $this->status = ($user = $this->getUser()) ? $user->status : User::STATUS_NOT_ACTIVE;
            if ($this->status === User::STATUS_ACTIVE)
            {
                return Yii::$app->user->login($user, $this->rememberMe ? 3600*24*30 : 0);
            }
            else
            {
                return false;
            }
        }
    }

}