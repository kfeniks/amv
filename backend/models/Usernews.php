<?php

namespace backend\models;

use Yii;


class UserNews extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_news';
    }
    const STATUS_OFF=0;
    const STATUS_ON=1;
    const NEWS_NORELEASE=0;
    const NEWS_RELEASE=1;

    public $fileImage;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'text', 'img'], 'required'],
            [['date_create'], 'safe'],
            [['is_release', 'hits', 'hide'], 'integer'],
            [['title'], 'string', 'max' => 70],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize'=>1024 * 1024 * 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'ID',
            'title' => 'Название',
            'text' => 'Текст',
            'is_release' => 'Важно?',
            'date_create' => 'Дата публикации',
            'date_update' => 'Дата обновления',
            'hits' => 'Просмотров',
            'hide' => 'Скрыто?',
        ];
    }

    public function getFolder()
    {
        $dirname = __DIR__.'/../../frontend/web/images/news/';

        if (file_exists($dirname)) {
            // echo "Папка $dir существует";
        } else {
            // echo "Папка $dir не существует";
            //  echo "Создаем папку $dir";
            mkdir("$dirname", 0700);
            //  echo "Создана папка $dir";
        }
        return $dirname;
    }

    public function getNameStatus(){
        if($this->hide == self::STATUS_OFF){return $nameStatus = 'Нет';}
        else{return $nameStatus = 'Да';}
    }
    public function getNameRelease(){
        if($this->is_release == self::STATUS_ON){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }

}
