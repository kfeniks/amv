<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "direct".
 *
 * @property integer $id
 * @property string $direct_url
 * @property integer $check_id
 * @property integer $check_availab
 * @property integer $videos_id
 */

class Direct extends ActiveRecord
{

    const STATUS_PENDING=1;
    const STATUS_APPROVED=2;
    const STATUS_ON=0;
    const STATUS_OFF=1;
    /**
     * @inheritdoc
     */


    public static function tableName()
    {
        return 'direct';
    }

    public function rules()
    {
        return [
            ['check_id', 'default', 'value' => self::STATUS_PENDING],
            ['check_availab', 'default', 'value' => self::STATUS_ON],
            ['check_availab', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF]],
            [['direct_url', 'format_id', 'codec_audio_id', 'codec_vid_id', 'duration', 'check_availab', 'check_id'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['duration'], 'safe'],
            [['check_availab', 'videos_id', 'format_id', 'codec_audio_id', 'codec_vid_id'], 'integer'],
            [['direct_url'], 'string', 'min' => 5, 'max' => 50],
            ['direct_url', 'url', 'defaultScheme' => 'http'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function attributeLabels()
    {
        return [
            'check_id' => 'Статус',
            'check_availab' => 'Показывать всем?',
            'direct_url' => 'Внешняя ссылка на клип',
            'format_id' => 'Формат видео',
            'codec_audio_id' => 'Аудио кодек',
            'codec_vid_id' => 'Видео кодек',
            'duration' => 'Продолжительность',
            'videos_id' => 'Номер видео'
        ];
    }

    public function getFormat()
    {

        return $this->hasOne(Format::className(), ['format_id' => 'id']);
    }

    public function getCheckVid()
    {

        return $this->hasOne(CheckVid::className(), ['check_id' => 'id']);
    }

    public function getCodecAudio()
    {

        return $this->hasOne(CodecAudio::className(), ['codec_audio_id' => 'id']);
    }

    public function getCodecVid()
    {

        return $this->hasOne(CodecVid::className(), ['codec_vid_id' => 'id']);
    }

    public function getVideos()
    {

        return $this->hasOne(Videos::className(), ['id' => 'videos_id']);
    }

    public function getCounters()
    {
        return $this->updateCounters(['load_count' => 1]);
    }

    public function formatName()
    {
        $format = Format::findOne($this->format_id);
        $formatName = $format->name;
        return $formatName;
    }

    public function CodecAudioName()
    {
        $format = CodecAudio::findOne($this->codec_audio_id);
        $name = $format->name;
        return $name;
    }

    public function CodecVidName()
    {
        $format = CodecVid::findOne($this->codec_vid_id);
        $name = $format->name;
        return $name;
    }

    public function getUserDownloads()
    {
        if (Yii::$app->user->isGuest) {}
        else{
            if($this->user_id !== Yii::$app->user->identity->id){
                $video = Userdownloads::find()->where(['videos_id' => $this->videos_id])->andwhere(['user_id' => Yii::$app->session->get('idVideo')])->one();
                if($video){}
                else{
                    $videos_downloads = new Userdownloads();
                    $videos_downloads->videos_id = $this->videos_id;
                    $videos_downloads->user_id = Yii::$app->user->identity->id;
                    $videos_downloads->save();
                }
            }
        }

    }
}
