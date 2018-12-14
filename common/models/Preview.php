<?php

namespace common\models;

use yii\db\ActiveRecord;


/**
 * This is the model class for table "preview".
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
            [['preview_url', 'file_size', 'format_id', 'codec_audio_id', 'codec_vid_id', 'check_availab', 'user_id', 'videos_id', 'check_id', 'load_count'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['local_url', 'url', 'yadi', 'vk', 'dropbox'], 'string', 'max' => 255],
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

        return $this->hasOne(Format::className(), ['id' => 'format_id']);
    }
    public function getCheckVid()
    {

        return $this->hasOne(CheckVid::className(), ['id' => 'check_id']);
    }
    public function getCodecAudio()
    {

        return $this->hasOne(CodecAudio::className(), ['id' => 'codec_audio_id']);
    }
    public function getCodecVid()
    {

        return $this->hasOne(CodecVid::className(), ['id' => 'codec_vid_id']);
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
        if(in_array('video/x-msvideo', $headers) xor in_array('video/mp4', $headers) xor in_array('video/mpeg', $headers) xor in_array('video/x-ms-wmv', $headers) xor in_array('video/x-matroska', $headers)){return $cloud = 'файл доступен';}
        else{return $cloud = 'нет файла';}
    }

    public function getYadiCloud()
    {
        //https://getfile.dokpub.com/yandex/get/https://yadi.sk/i/1X5WV_yk3M5Bzc
        return $file = 'https://getfile.dokpub.com/yandex/get/https://yadi.sk/'.$this->yadi;
    }

    public function getVkCloud()
    {
        //https://vk.com/doc5131697_449239941
        return $file = 'https://vk.com/doc'.$this->vk;
    }

    public function getDropboxCloud()
    {
        //https://www.dropbox.com/s/c2w68pfwarxdlwa/0134.Wolf_Snow_-_Night-Patrol_full.keccgroup.ru.avi?dl=1
        //c2w68pfwarxdlwa/0134.Wolf_Snow_-_Night-Patrol_full.keccgroup.ru.avi
        return $file = 'https://www.dropbox.com/s/'.$this->dropbox.'?dl=1';
    }

    public function getYadiExistsCloud()
    {
        //yandex.ru
        $url = $this->yadicloud;
        $headers = get_headers($url, 1);
        $http_response_code = substr($headers[0], 9, 3);
        if($http_response_code == '302'){return $cloud = '<b>файл доступен</b>';}
        else{return $cloud = 'нет файла';}
    }

    public function getVkExistsCloud()
    {
        $url = $this->vkcloud;
        $headers = get_headers($url, 1);
        $http_response_code = substr($headers[0], 9, 3);
        if($http_response_code == '302'){return $cloud = '<b>файл доступен</b>';}
        else{return $cloud = 'нет файла';}
    }

    public function getDropboxExistsCloud()
    {
        $url = $this->dropboxcloud;
        $headers = get_headers($url, 1);
        $http_response_code = substr($headers[0], 9, 3);
        if($http_response_code == '302'){return $cloud = '<b>файл доступен</b>';}
        else{return $cloud = 'нет файла';}
    }

}
