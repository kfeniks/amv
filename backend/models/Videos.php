<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;


class Videos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    const STATUS_PENDING=0;
    const STATUS_APPROVED=1;
    const STATUS_OFF=0;
    const STATUS_ON=1;

    public static function tableName()
    {
        return '{{%videos}}';
    }
    public $fileImage;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'author_id', 'img', 'anime', 'song', 'comments', 'availability', 'status', 'opinion_id', 'premiered', 'duration', 'hits'], 'required'],
            [['premiered', 'duration'], 'safe'],
            [['author_id', 'availability', 'is_recommended', 'status', 'opinion_id', 'award_week', 'award_month', 'hits'], 'integer'],
            [['title'], 'string', 'max' => 70],
            [['youtube'], 'string', 'min' => 4, 'max' => 20],
            [['meta_desc'], 'string', 'max' => 250],
            [['meta_key'], 'string', 'max' => 100],
            [['anime', 'song'], 'string', 'max' => 255],
            [['comments'], 'string', 'max' => 1000],
            [['title'], 'unique'],
            [['author_id'], 'exist', 'targetClass'=>'\frontend\models\User', 'targetAttribute'=>'id', 'message'=>'{attribute} должен существовать'],
            [['fileImage'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxSize'=>1024 * 1024 * 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'title' => 'Название',
            'author_id' => 'Автор',
            'img' => 'Картинка',
            'anime' => 'Аниме',
            'song' => 'Песня',
            'premiered' => 'Премьера',
            'youtube' => 'на ютубе',
            'comments' => 'Описание',
            'hits' => 'Посещений',
            'availability' => 'Одобрено',
            'is_recommended' => 'Рекомендовано?',
            'opinion_id' => 'Отзыв',
            'fileImage' => 'Картинка-скриншот',
            'fileImageUpdate' => 'Картинка-скриншот',
            'duration' => 'Продолжительность',
            'award_week' => 'Клип нед(в проф)',
            'award_month' => 'Клип мес(на глав)',
            'meta_key' => 'Мета ключи',
            'meta_desc' => 'Мета описание',

            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',

            'status' => 'Показывать всем?'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
    public function getLocal()
    {
        return $this->hasMany(\frontend\models\Local::className(), ['videos_id' => 'id']);
    }
    public function getDirect()
    {
        return $this->hasMany(\frontend\models\Direct::className(), ['videos_id' => 'id']);
    }
    public function getPreview()
    {
        return $this->hasMany(\frontend\models\Preview::className(), ['videos_id' => 'id']);
    }
    public function getCategory()
    {
        return $this->hasMany(\frontend\models\Category::className(), ['id' => 'category_id'])
            ->viaTable('videos_category', ['videos_id'=> 'id']);
    }
    public function getOpinion()
    {
        return $this->hasOne(\frontend\models\Opinion::className(), ['id' => 'opinion_id']);
    }

    public function getNameStatus(){
        if($this->status == self::STATUS_ON){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }

    public function getNameAvailability(){
        if($this->availability == self::STATUS_APPROVED){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }
    public function getNameRecommended(){
        if($this->is_recommended == self::STATUS_APPROVED){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }

    public function getNameOpinion(){
        if($this->opinion_id == 1){return $nameStatus = 'Нет';}
        elseif ($this->opinion_id == 2){return $nameStatus = 'Хор';}
        else{return $nameStatus = 'Выбор ред';}
    }
    public function getNameAwardWeek(){
        if($this->award_week == self::STATUS_APPROVED){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }
    public function getNameAwardMonth(){
        if($this->award_month == self::STATUS_APPROVED){return $nameStatus = 'Да';}
        else{return $nameStatus = 'Нет';}
    }

    public function getFolder()
    {
        $dirname = __DIR__.'/../../frontend/web/files/';
        $dir = $dirname.$this->user->username.'/';

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

    public function getSelectedCategory()
    {
        $selectedCategory = $this->getCategory()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedCategory, 'id');
    }

    public function saveCategory($category){
        if(is_array($category)){
            $this->cleanCurrentCategory();
            foreach ($category as $category_id){
                $videos_category = new \frontend\models\Videos_category();
                $videos_category->videos_id =  $this->id;
                $videos_category->category_id = $category_id;
                $videos_category->save();
            }
        }

    }
    public function cleanCurrentCategory(){
        \frontend\models\Videos_category::deleteAll(['videos_id' => Yii::$app->session->get('idVideo')]);
    }

    public function getAllDownloads(){
        User::find()->where(['id' => $this->author_id])->one();
        $localdownloads = \frontend\models\Local::find()->where(['videos_id' => $this->id])->one();
        $previewdownloads = \frontend\models\Preview::find()->where(['videos_id' => $this->id])->one();
        $directdownloads = \frontend\models\Direct::find()->where(['videos_id' => $this->id])->one();
        $count1 = $localdownloads->load_count;
        $count2 = $previewdownloads->load_count;
        $count3 = $directdownloads->load_count;
        $alldownloads = $count1+$count2+$count3;
        return $alldownloads;

    }

    public function getLinkLocal(){
        $localvideos = \frontend\models\Local::find()->where(['videos_id' => $this->id])->one();

        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $user = $this->author_id;
            $user_file = $localvideos->user_id;

            if($localvideos->check_id !== 1){$local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewlocal",
                    "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->file_size. 'мб. ';}
            else{
                if($user == $user_file){$status = $localvideos->checkVid->check_name;
                    $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewlocal",
                            "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->file_size. 'мб. '.$status;
                }
                else{$local = 'Файл не найден.';}
            }
            return $local;
        } else {
            return $error;
        }
    }

    public function getLinkPreview(){
        $localvideos = \frontend\models\Preview::find()->where(['videos_id' => $this->id])->one();
        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $user = Yii::$app->user->identity->id;
            $user_file = $localvideos->user_id;

            if($localvideos->check_id !== 1){$local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewpreview",
                    "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->file_size. 'мб. ';}
            else{
                if($user == $user_file){$status = $localvideos->checkVid->check_name;
                    $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewpreview",
                            "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->file_size. 'мб. '.$status;
                }
                else{$local = 'Файл не найден.';}
            }

            return $local;
        } else {
            return $error;
        }
    }

    public function getLinkDirect(){
        $localvideos = \frontend\models\Direct::find()->where(['videos_id' => $this->id])->one();


        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $user = Yii::$app->user->identity->id;
            $user_file = $localvideos->user_id;
            if($localvideos->check_id !== 1){$local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewdirect",
                    "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->filesize. 'мб. ';}
            else{
                if($user == $user_file){$status = $localvideos->checkVid->check_name;
                    $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewdirect",
                            "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->filesize. 'мб. '.$status;
                }
                else{$local = 'Файл не найден.';}
            }

            return $local;
        } else {
            return $error;
        }
    }


    public function siteOpinion()
    {
        $op = \frontend\models\Opinion::findOne($this->opinion_id);
        $opinion = $op->opinion_name. '. '.$op->opinion_comments;
        return $opinion;
    }

    public function amvAwards()
    {
        $is = '<p><b>Награды клипа:</b></p>';
        if($this->is_recommended == 1){$recommended = '<p>Клип выбран в "Золотую коллекцию клипов".</p>';}
        else $recommended = '';
        if($this->award_week == 1){$week = '<p>Клип был награжден как "Лучший клип недели".</p>';}
        else $week = '';
        if($this->award_month == 1){$month = '<p>Клип был награжден как "Лучший клип месяца".</p>';}
        else $month = '';
        if($recommended && $week && $month !== Null){$opinion = $is.$recommended.$week.$month;}
        else $opinion = '';
        return $opinion;
    }

    public function getCheckLocal(){
        $local = \frontend\models\Local::find()->where(['videos_id' => $this->id])->one();
        if($local->id !== Null){
            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/update_videos_step2", "id" => $local->id]).'" role="button">Редактировать основной файл</a></p>';
            $localLink = $link;
            return $localLink;
        } else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/create_local"]).'" role="button">Добавить основной файл</a></p>';
            $localLink = $link;
            return $localLink;
        }
    }

    public function getCheckPreview(){
        $preview = \frontend\models\Preview::find()->where(['videos_id' => $this->id])->one();
        $delete = Html::a('Удалить превью', ['deletepreview', 'id' => $preview->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы правда хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]);
        if($preview->id !== Null){
            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/update_videos_step3", "id" => $preview->id]).'" role="button">Редактировать превью файл</a> '.$delete.'</p>';
            $previewLink = $link;
            return $previewLink;
        } else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/create_preview"]).'" role="button">Добавить превью файл</a></p>';
            $previewLink = $link;
            return $previewLink;
        }
    }
    public function getCheckDirect(){
        $direct = \frontend\models\Direct::find()->where(['videos_id' => $this->id])->one();
        $delete = Html::a('Удалить ссылку', ['deletedirect', 'id' => $direct->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы правда хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]);
        if($direct->id !== Null){
            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/update_videos_step4", "id" => $direct->id]).'" role="button">Редактировать ссылку на внешний сервер</a> '.$delete.'</p>';
            $directLink = $link;
            return $directLink;
        }else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["videos/create_direct"]).'" role="button">Добавить ссылку на внешний сервер</a></p>';
            $directLink = $link;
            return $directLink;
        }
    }

    public function getCheckVideos(){
        $delete = Html::a('Удалить клип', ['deletevideos', 'id' => $this->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы правда хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]);
        if($this->id !== Null){
            $link = '<p>'.$delete.'</p>';
            $videosLink = $link;
            return $videosLink;
        } else{
            return $videosLink = '';
        }
    }

    public  function getCategoryIndex(){
        $category = \frontend\models\Videos_category::find()->where(['videos_id' => $this->id])->orderBy('id DESC')->all();
        foreach ($category as $cat){
            $cat1 = Yii::$app->urlManager->createUrl(["category/view", "id" => $cat->category_id]);
            $cat2 = Html::encode($cat->catName);
            $cat3 = '<a class="btn btn-default" href="'.$cat1.'" role="button">'.$cat2.'</a>';
            echo $cat3;
        }
    }
}
