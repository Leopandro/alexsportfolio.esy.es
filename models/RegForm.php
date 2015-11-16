<?php
/**
 * Created by PhpStorm.
 * User: Алексей
 * Date: 06.11.2015
 * Time: 14:46
 */

namespace app\models;
use yii\base\Model;
use Yii;

class RegForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $status;

    public function rules()
    {
        return [
            [['username', 'email', 'password'], 'filter', 'filter' => 'trim'],
            [['username', 'email', 'password'],'required'],
            ['username', 'unique',
                'targetClass' => User::className(),
                'message' => 'Это имя уже занято'
            ],
            ['email', 'email'],
            ['email', 'unique',
                'targetClass' => User::className(),
                'message' => 'Эта почта уже занята'
            ],
            ['status', 'default', 'value' => User::STATUS_ACTIVE, 'on' => 'default'],
            ['status', 'in', 'range' =>
                [
                    User::STATUS_ACTIVE,
                    User::STATUS_DELETED
                ]
            ]
        ];
    }

    public function reg()
    {
        $user = new User;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->status = $this->status;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        return $user->save() ? $user : null;
    }
    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'email' => 'Эл. почта',
            'password' => 'Пароль'
        ];
    }
}