<?php

namespace backend\models;

use Yii;


class Faqs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'faqs';
    }
    const STATUS_OFF=0;
    const STATUS_ON=1;
    const STATUS_SITE=1;
    const STATUS_PROFILE=2;
    const STATUS_AMV=3;

    public $fileImage;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'text', 'cat_id', 'status'], 'required'],
            [['create_date'], 'safe'],
            [['cat_id', 'hits', 'status'], 'integer'],
            [['name'], 'string', 'max' => 70],
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
            'name' => 'Название',
            'text' => 'Текст',
            'cat_id' => 'Раздел',
            'create_date' => 'Дата публикации',
            'hits' => 'Просмотров',
            'status' => 'Показывать?',
        ];
    }

    public function getFolder()
    {
        $dirname = __DIR__.'/../../frontend/web/images/faqs/';

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
        if($this->status == self::STATUS_OFF){return $nameStatus = 'Нет';}
        else{return $nameStatus = 'Да';}
    }
    public function getNameRelease(){
        if($this->cat_id == self::STATUS_SITE){return $nameStatus = 'Сайт';}
        elseif($this->cat_id == self::STATUS_PROFILE){return $nameStatus = 'Профиль';}
        else{return $nameStatus = 'Амв';}
    }

}
