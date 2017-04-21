<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

class VideosUpdate extends ActiveRecord
{
    const STATUS_PENDING=0;
    const STATUS_APPROVED=1;
    const STATUS_OFF=0;
    const STATUS_ON=1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videos';
    }
    public $fileImage;
    /**
     * Список тэгов, закреплённых за постом.
     * @var array
     *  protected $categoryName = [];
     */

    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ON],
            ['status', 'in', 'range' => [self::STATUS_ON, self::STATUS_OFF]],
            [['title', 'anime', 'song', 'premiered', 'comments'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['title', 'anime', 'song', 'img'], 'string', 'min' => 5, 'max' => 150],
            [['comments'], 'string', 'min' => 5, 'max' => 1000],
            [['youtube'], 'string', 'min' => 4, 'max' => 20],
            [['premiered'], 'safe'],
            [['author_id', 'status'], 'integer'],
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
            'youtube' => 'youtube',
            'comments' => 'Описание',
            'hits' => 'Посещений',
            'hide' => 'Публикация',
            'status' => 'Показывать всем?'
        ];
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

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
    public function getLocal()
    {
        return $this->hasMany(Local::className(), ['videos_id' => 'id']);
    }
    public function getDirect()
    {
        return $this->hasMany(Direct::className(), ['videos_id' => 'id']);
    }
    public function getPreview()
    {
        return $this->hasMany(Preview::className(), ['videos_id' => 'id']);
    }
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('videos_category', ['videos_id'=> 'id']);
    }

    public function ifMyClip()
    {
        if($this->author_id != Yii::$app->user->identity->id){
            return header('Refresh: 0; url=' . Yii::$app->urlManager->createUrl(["profile/create"]) . '');
        }
    }

    public function checkVideoStatus()
    {
        if($this->status == 0){
            return header('Refresh: 0; url=' . Yii::$app->urlManager->createUrl(["site/index"]) . '');
        }
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
                //  $category = Category::findOne($category_id);
                $videos_category = new Videos_category();
                $videos_category->videos_id =  Yii::$app->session->get('idVideo');
                $videos_category->category_id = $category_id;
                $videos_category->save();
            }
        }

    }

    public function cleanCurrentCategory(){
        Videos_category::deleteAll(['videos_id' => Yii::$app->session->get('idVideo')]);
    }

    public function getAllDownloads(){
        User::find()->where(['id' => Yii::$app->user->identity->id])->one();
        $localdownloads = Local::find()->where(['videos_id' => $this->id])->one();
        $previewdownloads = Preview::find()->where(['videos_id' => $this->id])->one();
        $directdownloads = Direct::find()->where(['videos_id' => $this->id])->one();
        $count1 = $localdownloads->load_count;
        $count2 = $previewdownloads->load_count;
        $count3 = $directdownloads->load_count;
        $alldownloads = $count1+$count2+$count3;
        return $alldownloads;

    }

    public function getLinkLocal(){
        $localvideos = Local::find()->where(['videos_id' => $this->id])->one();;
        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewlocal", "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->FileSize. 'мб.';
            return $local;
        } else {
            return $error;
        }
    }

    public function getLinkPreview(){
        $localvideos = Preview::find()->where(['videos_id' => $this->id])->one();;
        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewpreview", "id" => $localvideos->id]). '" role="button">Скачать</a> '. $localvideos->FileSize. 'мб.';
            return $local;
        } else {
            return $error;
        }
    }

    public function getLinkDirect(){
        $localvideos = Direct::find()->where(['videos_id' => $this->id])->one();;
        $error = 'Файл не найден.';
        if (($localvideos) !== null) {
            $local = '<a class="btn btn-lg btn-success" href="'. Yii::$app->urlManager->createUrl(["videos/viewdirect", "id" => $localvideos->id]). '" role="button">Скачать</a>';
            return $local;
        } else {
            return $error;
        }
    }

    public function getOpinion()
    {
        return $this->hasMany(Opinion::className(), ['opinion_id' => 'id']);
    }

    public function siteOpinion()
    {
        $op = Opinion::findOne($this->opinion_id);
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

}