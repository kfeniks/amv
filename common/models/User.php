<?php
namespace common\models;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\HtmlPurifier;

/**
 * User model
 *
 * @property integer $id
 * @property integer $karma
 * @property integer $num
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $level
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 5;
    const STATUS_ACTIVE = 10;

    public $fileImage;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'name', 'email'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['name', 'website', 'city'], 'string', 'max' => 150],
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Автор',
            'name' => 'Имя',
            'profile_type' => 'Profile Type',
            'avatar' => 'Avatar',
            'sex' => 'Пол',
            'sex_id' => 'ID пола',
            'birthdate_day' => 'Мой День Рождения',
            'country' => 'Страна',
            'country_id' => 'ID cтраны',
            'city' => 'Город',
            'website' => 'Вебсайт',
            'about' => 'Обо мне',
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
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSex()
    {

        return $this->hasOne(Sex::className(), ['id' => 'sex_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {

        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['user_id_to' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserdownloads()
    {
        return $this->hasMany(Userdownloads::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRankusers()
    {
        return $this->hasMany(Rankusers::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWishlist()
    {
        return $this->hasMany(Wishlist::className(), ['user_id' => 'id']);
    }

    /**
     * Getting the status of Karma by the number of bonuses in the account
     *
     * @param int $karma
     * @param int $num
     * @param string $level
     * @return string $karmaStatus
     */
    public function getKarmaStatus()
    {
        $karma = number_format($this->karma) . ' симпатий ';
        $num = $this->karma;
        $level = '';
        if($num < 5000){$level = '<em>Новичок</em>';}
        elseif($num >= 5000){$level = '<em>Активный</em>';}
        elseif($num >= 15000){$level = '<em>Знаток</em>';}
        elseif($num >= 25000){$level = '<em>Наставник</em>';}
        elseif($num >= 35000){$level = '<em>Гуру</em>';}
        elseif($num >= 45000){$level = '<em>уровень GodMode</em>';}
        return $karma.'('.$level.')';
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
    public function getPreview()
    {
        return $this->hasMany(Preview::className(), ['user_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDirect()
    {
        return $this->hasMany(Direct::className(), ['user_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIpBehavior()
    {
        return $this->hasMany(IpBehavior::className(), ['user_id' => 'id']);
    }

    /**
     * Getting the current user's ip address list
     *
     * @param array $ips
     * @param int $ip1
     * @param string $ip2
     * @param string $ip3
     * @param string $ip4
     * @return string $result
     */
    public function getIp()
    {
        $ips = IpBehavior::find()->where(['user_id' => $this->id])->limit(10)->orderBy('id DESC')->all();
        if($ips !== null){
            $result = '';
            foreach ($ips as $user){
                $ip1 = $user->ip;
                $ip2 = HtmlPurifier::process(Yii::$app->formatter->asDate($user->date, 'd MMMM yyyy'));
                $ip3 = $user->host;
                $ip4 = '<p>'.$ip1.' || '.$ip2.' || '.$ip3.'</p><br>';
                $result .= $result . $ip4;
            }
        }else{$result = 'Нет записей об IP';}
        return $result;
    }
}
