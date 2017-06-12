<?php

namespace frontend\models;
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
    public $fileAmv;
    public function rules()
    {
        return [
            [['preview_url', 'format_id', 'codec_audio_id', 'codec_vid_id', 'check_availab'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['check_availab', 'format_id', 'codec_audio_id', 'codec_vid_id'], 'integer'],
            [['fileAmv'], 'file', 'skipOnEmpty' => true, 'extensions' => 'avi, mp4, mov, flv, mpeg, wmv, mkv, vob', 'maxSize'=>1024 * 1024 * 20],
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
            'fileAmv' => 'Файл клипа',
            'videos_id' => 'Номер видео'
        ];
    }

    public function getFormat()
    {

        return $this->hasOne(Format::className(), ['format_id' => 'id']);
    }
    public function getCheckVid()
    {

        return $this->hasOne(CheckVid::className(), ['id' => 'check_id']);
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

    public function getFolder()
    {
        $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $dirname = __DIR__.'/../web/files/';
        $dir = $dirname.$user->username.'/';

        if (file_exists($dir)) {
            // echo "Папка $dir существует";
        } else {
            // echo "Папка $dir не существует";
            //  echo "Создаем папку $dir";
            mkdir("$dir", 0700);
            //  echo "Создана папка $dir";
        }
        return $dir;
    }

    public function getFileSize()
    {
        $dirname = __DIR__.'/../web/files';
        $filename = $dirname.'/'.$this->preview_url;
        if (file_exists($filename)) {
            $filename_mb = (filesize($filename)/1024)/1024;
            $filename_mb = str_replace(".", "," , strval(round($filename_mb, 2)));
        }
        else {
            $filename_mb = 0;
        }
        return $filename_mb;
    }

    public function getUser()
    {
        return User::find()->where(['id' => $this->user_id])->one();
    }

    public function getRefresh()
    {
        if($this->check_id !== self::STATUS_APPROVED){return header( 'Refresh: 0; url='.Yii::$app->urlManager->createUrl(["site/index"]).'' );}
        else
        {return header( 'Refresh: 5; url='.Yii::$app->urlManager->createUrl(["videos/download_preview", "id" => $this->id]).'' );}
    }
    public function getCounters()
    {
        return $this->updateCounters(['load_count' => 1]);
    }
    public function getFileDir()
    {
        return $file = __DIR__.'/../web/files/'.$this->preview_url;
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
        else{
            echo $cloud = 'Упс, этого файла нет на сервере. Обратитесь к администратору.';
            return header( 'Refresh: 5; url='.Yii::$app->urlManager->createUrl(["site/index"]).'' );
            }
    }

    public function getCloudExists()
    {
        $url = $this->filecloud;
        $headers = get_headers($url, 1);
        if(in_array('video/x-msvideo', $headers)){return $cloud = 200;}
        elseif (in_array('video/mp4', $headers)){return $cloud = 200;}
        elseif (in_array('video/mpeg', $headers)){return $cloud = 200;}
        else{
            return $cloud = 404;
        }
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
