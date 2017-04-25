<?php

namespace frontend\models;
use Yii;


/**
 * This is the model class for table "posts".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class User extends \yii\db\ActiveRecord
{

    const STATUS_PENDING=0;
    const STATUS_NOT_ACTIVE = 5;
    const STATUS_APPROVED=10;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
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
            'id' => 'Id',

        ];
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

}
