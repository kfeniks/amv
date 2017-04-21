<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $name;
    public $email;
    public $password;


    public function attributeLabels()
    {
        return [
            'username' => 'Ваш логин',
            'name' => 'Ваше имя',
            'email' => 'Ваш е-маил адрес',
            'password' => 'Пароль',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required', 'message' => 'Необходимо заполнить поле.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот логин уже занят.'],
            ['username', 'string', 'min' => 5, 'max' => 255],

            ['name', 'trim'],
            ['name', 'required', 'message' => 'Необходимо заполнить поле.'],
            ['name', 'string', 'min' => 4, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Необходимо заполнить поле.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Этот емеил уже зарегистрирован у нас.'],

            ['password', 'required', 'message' => 'Необходимо заполнить поле.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
