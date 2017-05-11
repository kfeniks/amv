<?php

namespace backend\models;

use Yii;


class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }
    const STATUS_OFF=0;
    const STATUS_ON=1;

    public $fileImage;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'intro_text', 'full_text'], 'required'],
            [['date'], 'safe'],
            [['is_release', 'hits', 'hide'], 'integer'],
            [['title'], 'string', 'max' => 70],
            [['meta_key'], 'string', 'max' => 70],
            [['meta_desc'], 'string', 'max' => 200],
            [['intro_text'], 'string', 'max' => 250],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize'=>1024 * 1024 * 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'intro_text' => 'Краткое описание',
            'full_text' => 'Текст',
            'is_release' => 'Релиз?',
            'date' => 'Дата публикации',
            'date_update' => 'Дата обновления',
            'meta_desc' => 'Мета описание',
            'meta_key' => 'Мета ключи',
            'hits' => 'Просмотров',
            'hide' => 'Показывать?',
        ];
    }

    public function getFolder()
    {
        $dirname = __DIR__.'/../../frontend/web/images/posts/';

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
        if($this->hide == self::STATUS_ON){return $nameStatus = 'Нет';}
        else{return $nameStatus = 'Да';}
    }
    public function getNameRelease(){
        if($this->is_release == self::STATUS_ON){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }

}
