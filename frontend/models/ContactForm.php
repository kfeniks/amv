<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $subject;
    public $body;
    public $verifyCode;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['subject', 'body'], 'required'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Капча',
            'name' => 'Имя',
            'email' => 'Емеил',
            'subject' => 'Тема вопроса',
            'body' => 'Вопрос',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return bool whether the email was sent
     */

    public function getUser()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        return $user->name;
    }

    public function sendEmail($email)
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $this->email = $user->email;
        $this->name = $user->username.'('.$user->name.')';
        return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();
    }
}
