<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $reg_date
 * @property string $profile_type
 * @property string $avatar
 * @property string $sex
 * @property string $birthdate_day
 * @property string $country
 * @property string $city
 * @property string $website
 * @property string $about
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $admin_role
 * @property integer $karma
 *
 * @property Local[] $locals
 * @property Videos[] $videos
 */
class User extends \yii\db\ActiveRecord
{
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
            [['username', 'name', 'sex', 'birthdate_day', 'country', 'city', 'website', 'about', 'auth_key', 'password_hash', 'email'], 'required'],
            [['birthdate_day'], 'safe'],
            [['status', 'created_at', 'updated_at', 'admin_role', 'karma'], 'integer'],
            [['username', 'name', 'profile_type', 'avatar', 'sex', 'country', 'city', 'website', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['about'], 'string', 'max' => 250],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'name' => 'Name',
            'profile_type' => 'Profile Type',
            'avatar' => 'Avatar',
            'sex' => 'Sex',
            'birthdate_day' => 'Birthdate Day',
            'country' => 'Country',
            'city' => 'City',
            'website' => 'Website',
            'about' => 'About',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'admin_role' => 'Admin Role',
            'karma' => 'Karma',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocals()
    {
        return $this->hasMany(Local::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['author_id' => 'id']);
    }
}
