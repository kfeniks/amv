<?php

namespace backend\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "category".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Preview extends ActiveRecord
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
        return 'preview';
    }

    public function rules()
    {
        return [
            [['preview_url', 'url', 'file_size', 'format_id', 'codec_audio_id', 'codec_vid_id', 'check_availab', 'user_id', 'videos_id', 'check_id', 'load_count'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['check_availab', 'format_id', 'codec_audio_id', 'codec_vid_id', 'user_id', 'videos_id', 'check_id', 'load_count'], 'integer'],
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
            'local_url' => 'Путь до файла',
            'format_id' => 'Формат видео',
            'codec_audio_id' => 'Аудио кодек',
            'codec_vid_id' => 'Видео кодек',
            'load_count' => 'Количество скачиваний',
            'user_id' => 'Автор',
            'videos_id' => 'Номер видео'
        ];
    }

    public function getFormat()
    {

        return $this->hasOne(\frontend\models\Format::className(), ['id' => 'format_id']);
    }
    public function getCheckVid()
    {

        return $this->hasOne(\frontend\models\CheckVid::className(), ['id' => 'check_id']);
    }
    public function getCodecAudio()
    {

        return $this->hasOne(\frontend\models\CodecAudio::className(), ['id' => 'codec_audio_id']);
    }
    public function getCodecVid()
    {

        return $this->hasOne(\frontend\models\CodecVid::className(), ['id' => 'codec_vid_id']);
    }

    public function getVideos()
    {

        return $this->hasOne(Videos::className(), ['id' => 'videos_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }


    public function getFileCloud()
    {
        return $file = 'https://rocld.com/'.$this->url;
    }
    public function getFileExistsCloud()
    {
        $url = $this->filecloud;
        $headers = get_headers($url, 1);
        if(in_array('video/x-msvideo', $headers)){return $cloud = 'файл доступен';}
        elseif (in_array('video/mp4', $headers)){return $cloud = 'файл доступен';}
        else{return $cloud = 'нет файла';}
    }

}
