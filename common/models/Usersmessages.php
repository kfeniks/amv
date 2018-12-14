<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "users_messages".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Usersmessages extends ActiveRecord
{
    const STATUS_OFF=0;
    const STATUS_ON=1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_messages';
    }

    public function rules()
    {
        return [
            [['subject', 'user_id_to', 'message', 'status'], 'required'],
            [['date_time'], 'safe'],
            [['user_id_from', 'user_id_to', 'status'], 'integer'],
            [['subject'], 'string', 'max' => 50],
            [['message'], 'string', 'max' => 1000],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id_from' => 'Автор',
            'user_id_to' => 'Пользователю',
            'date_time' => 'Дата создания',
            'status' => 'Прочитано?',
            'subject' => 'Тема',
            'message' => 'Сообщение',

        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id_to']);
    }

    public function getNameStatus(){
        if($this->status == self::STATUS_OFF){return $nameStatus = 'Нет';}
        else{return $nameStatus = 'Да';}
    }

    public function getNameUser(){
        $user = $this->user->username;
        $link = '<a href="'. Yii::$app->urlManager->createUrl(["user/view", "id" => $this->user_id_to]). '" role="button">'. $user . '</a>';
        return $link;
    }


}
