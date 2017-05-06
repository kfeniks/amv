<?php
namespace common\models;
use frontend\models\Sex;
use frontend\models\Country;
use frontend\models\Videos;
use frontend\models\Messages;
use frontend\models\Rankusers;
use frontend\models\Userdownloads;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_NOT_ACTIVE = 5;
    const STATUS_ACTIVE = 10;


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
            [['name', 'email'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['name', 'website', 'city'], 'string', 'max' => 150],
            [['about'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['birthdate_day'], 'safe'],
            [['sex_id', 'country_id'], 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'username' => 'Автор',
            'sex_id' => 'Пол',
            'country_id' => 'Страна',
            'website' => 'Вебсайт',
            'country' => 'Страна',
            'city' => 'Город',
            'about' => 'Обо мне',
            'birthdate_day' => 'Мой День Рождения',

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

    public function getSex()
    {

        return $this->hasOne(Sex::className(), ['id' => 'sex_id']);
    }

    public function getCountry()
    {

        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['author_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Messages::className(), ['user_id_to' => 'id']);
    }

    public function getUserdownloads()
    {
        return $this->hasMany(Userdownloads::className(), ['user_id' => 'id']);
    }

    public function getRankusers()
    {
        return $this->hasMany(Rankusers::className(), ['user_id' => 'id']);
    }

    public function getKarmaStatus()
    {
        $karma = number_format($this->karma) . ' симпатий ';
        $num = $this->karma;
        if($num < 5000){$level = '<em>Новичок</em>';};
        if($num >= 5000){$level = '<em>Активный</em>';};
        if($num >= 15000){$level = '<em>Знаток</em>';};
        if($num >= 25000){$level = '<em>Наставник</em>';};
        if($num >= 35000){$level = '<em>Гуру</em>';};
        if($num >= 45000){$level = '<em>уровень GodMode</em>';};
        return $karmaStatus = $karma.'('.$level.')';
    }
    public function getSexName()
    {
        $sex_user = Sex::find()->where(['id' => $this->sex_id])->one();
        $sexName = $sex_user->name;
        return $sexName;
    }
    public function getCountryName()
    {
        $country_user = Country::find()->where(['id' => $this->country_id])->one();
        $countryName = $country_user->name;
        return $countryName;
    }
}
