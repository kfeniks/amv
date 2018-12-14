<?php
namespace frontend\models;

use Yii;
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
    public $verifyCode;


    public function attributeLabels()
    {
        return [
            'username' => 'Ваш логин',
            'name' => 'Ваше имя',
            'email' => 'Ваш е-маил адрес',
            'password' => 'Пароль',
            'verifyCode' => 'Капча',
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

            ['verifyCode', 'captcha'],
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
        $user->check_request = $this->generateCheck();
        return $user->save() ? $user : null;
    }

    public function generateCheck()
    {
        // Символы, которые будут использоваться в пароле.
        $chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        // Количество символов в пароле.
        $max=16;
        // Определяем количество символов в $chars
        $size=StrLen($chars)-1;
        // Определяем пустую переменную, в которую и будем записывать символы.
        $password=null;
        // Создаём пароль.
        while($max--)
            $password.=$chars[rand(0,$size)];

        return $password;
    }

    private function findUser($email){
        $user = User::find()->where(['email'=>$email])->one();
        return $user->check_request;
    }

    public function sendEmail($email)
    {
        if ($email == null) {
            return null;
        }
        $check_request = $this->findUser($email);
        $userName = 'Администрация сайта';
        $emailSite = 'amv.pp.ua@yandex.ru';
        $subject = 'Регистрация на сайте';
        $body = '
             Регистрация на сайте AMV.PP.UA             
             Здравствуй, друг! Спасибо большое, что зарегистрировался на нашем сайте.
             Для активации аккаунта на сайте скопируйте и введите ссылку ниже:
             http://amv.pp.ua/activation.html?activation_code='.$check_request.'&user_email='.$this->email.'            
        ';
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$emailSite => $userName])
            ->setSubject($subject)
            ->setTextBody($body)
            ->send();
    }
}
