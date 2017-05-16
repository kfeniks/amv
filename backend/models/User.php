<?php

namespace backend\models;

use Yii;
use yii\helpers\HtmlPurifier;

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

    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 5;
    const STATUS_ACTIVE = 10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }
    public $fileImage;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'email'], 'required'],
            [['birthdate_day'], 'safe'],
            [['status', 'created_at', 'karma', 'sex_id', 'country_id'], 'integer'],
            [['username', 'name', 'profile_type', 'city', 'website', 'email'], 'string', 'max' => 255],
            [['about'], 'string', 'max' => 250],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize'=>1024 * 300 * 1],
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
        return $this->hasMany(\frontend\models\Local::className(), ['user_id' => 'id']);
    }
    public function getPreview()
    {
        return $this->hasMany(\frontend\models\Preview::className(), ['user_id' => 'id']);
    }
    public function getDirect()
    {
        return $this->hasMany(\frontend\models\Direct::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['author_id' => 'id']);
    }
    public function getCountry()
    {

        return $this->hasOne(\frontend\models\Country::className(), ['id' => 'country_id']);
    }
    public function getSex()
    {

        return $this->hasOne(\frontend\models\Sex::className(), ['id' => 'sex_id']);
    }
    public function getStatus()
    {
        if($this->status == 0){return $status ='Забанен';}
        elseif ($this->status == 5){return $status ='Ожидает активации (почта)';}
        elseif($this->status == 10){return $status ='Активен';}
    }
    public function getIpBehavior()
    {
        return $this->hasMany(\frontend\models\IpBehavior::className(), ['user_id' => 'id']);
    }

    public function getIp()
    {
        $ips = \frontend\models\IpBehavior::find()->where(['user_id' => $this->id])->limit(10)->orderBy('id DESC')->all();
        if($ips !== null){
        foreach ($ips as $ip){
            $ip1 = $ip->ip;
            $ip2 = HtmlPurifier::process(Yii::$app->formatter->asDate($ip->date, 'd MMMM yyyy'));
            $ip3 = $ip->host;
            $ip4 = '<p>'.$ip1.' || '.$ip2.' || '.$ip3.'</p><br>';
            return $ip4;
        }
        }else{return $ip4 = 'Нет записей об IP';}
    }
}
