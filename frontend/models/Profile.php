<?php

namespace frontend\models;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;



/**
 * This is the model class for table "user".
 *

 */

class Profile extends ActiveRecord implements IdentityInterface
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'sex' => 'Пол',
            'website' => 'Вебсайт',
            'country' => 'Страна',
            'city' => 'Город',
            'about' => 'Обо мне',

        ];
    }

    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['author_id' => 'id']);
    }

    public function getMessages()
    {

        return $this->hasMany(Messages::className(), ['user_id_from' => 'id']);
    }

}
