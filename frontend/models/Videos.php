<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ActiveForm;

class Videos extends ActiveRecord
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
            'fileImage' => 'Картинка-скриншот',
            'fileImageUpdate' => 'Картинка-скриншот',
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
    public function getUserdownloads()
    {
        return $this->hasMany(Userdownloads::className(), ['videos_id' => 'id']);
    }
    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('videos_category', ['videos_id'=> 'id']);
    }
    public function getRankings()
    {
        return $this->hasMany(Rankings::className(), ['id' => 'rank_id'])
            ->viaTable('rank_users', ['videos_id'=> 'id']);
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
    public function getRating(){
        $rating='';
        $count='';
        $sum = Rankusers::find()->where(['videos_id' => $this->id])->all();
        foreach($sum as $plus){
            $rating = $rating+$plus->rank_id;
            $count = $count+1;
        }
        if($rating>0) {
            $rate = $rating / $count;
            $star = (100*$rate)/5;
            $icon = '<i class="fa fa-users fa-1" aria-hidden="true"></i>';
            $rating = '<div class="rating"><div class="stars">';
            $ratingStart = '<div class="on" style="width: '.$star.'%;"></div> <div class="live">';
            $ratingEnd = '</div></div></div>';
            $link1 = '<span data-rate="1" ></span>';
            $link2 = '<span data-rate="2" ></span>';
            $link3 = '<span data-rate="3" ></span>';
            $link4 = '<span data-rate="4" ></span>';
            $link5 = '<span data-rate="5" ></span>';
            $link =  $rating.$ratingStart.$link1.$link2.$link3.$link4.$link5.$ratingEnd.$count.$icon;
            return $link;
        }else{
            $result = 'У этого клипа еще нет оценок. Зарегистрируйтесь на сайте, чтобы оставить оценку.';
            return $result;
        }
    }

    public function getSelectedRankings()
    {
        $selectedCategory = $this->getCategory()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedCategory, 'id');
    }

    public function saveRankings($rankings){
        if(is_array($rankings)){
            $this->cleanCurrentRankings();
            foreach ($rankings as $rankings_id){
                $videos_rankings = new Videos_category();
                $videos_rankings->videos_id =  $this->id;
                $videos_rankings->rank_id = $rankings_id;
                $videos_rankings->user_id = Yii::$app->user->identity->id;
                $videos_rankings->save();
            }
        }

    }

    public function cleanCurrentRankings(){
        Rankusers::deleteAll(['videos_id' => $this->id] && ['user_id'=>Yii::$app->user->identity->id]);
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

    public function getCheckLocal(){
        $local = Local::find()->where(['videos_id' => $this->id])->one();
        if($local->id !== Null){
            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/update_videos_step2", "id" => $local->id]).'" role="button">Редактировать основной файл</a></p>';
            $localLink = $link;
            return $localLink;
        } else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/upload_local"]).'" role="button">Добавить основной файл</a></p>';
            $localLink = $link;
            return $localLink;
        }
    }

    public function getCheckPreview(){
        $preview = Preview::find()->where(['videos_id' => $this->id])->one();
        $delete = Html::a('Удалить превью', ['deletepreview', 'id' => $preview->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы правда хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]);
        if($preview->id !== Null){
          $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/update_videos_step3", "id" => $preview->id]).'" role="button">Редактировать превью файл</a> '.$delete.'</p>';
            $previewLink = $link;
            return $previewLink;
        } else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/upload_preview"]).'" role="button">Добавить превью файл</a></p>';
            $previewLink = $link;
            return $previewLink;
        }
    }
    public function getCheckDirect(){
        $direct = Direct::find()->where(['videos_id' => $this->id])->one();
        $delete = Html::a('Удалить ссылку', ['deletedirect', 'id' => $direct->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы правда хотите удалить эту запись?',
                'method' => 'post',
            ],
        ]);
        if($direct->id !== Null){
            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/update_videos_step4", "id" => $direct->id]).'" role="button">Редактировать ссылку на внешний сервер</a> '.$delete.'</p>';
            $directLink = $link;
            return $directLink;
        }else{

            $link = '<p><a href="'.Yii::$app->urlManager->createUrl(["profile/upload_direct"]).'" role="button">Добавить ссылку на внешний сервер</a></p>';
            $directLink = $link;
            return $directLink;
        }
    }

    public  function getCategoryIndex(){
        $category = Videos_category::find()->where(['videos_id' => $this->id])->orderBy('id DESC')->all();
                                foreach ($category as $cat){
                                    $cat1 = Yii::$app->urlManager->createUrl(["category/view", "id" => $cat->category_id]);
                                    $cat2 = Html::encode($cat->catName);
                                    $cat3 = '<a class="btn btn-default" href="'.$cat1.'" role="button">'.$cat2.'</a>';
                                    echo $cat3;
                                 }
    }

    public function getVidComments()
    {
        return $this->hasMany(VidComments::className(), ['videos_id' => 'id']);
    }

    public function getComments()
    {
        return $this->getVidComments()->orderBy('id DESC')->all();
    }

    public function getUserComments()
    {
        $SelectedComments = $this->getComments();

        foreach ($SelectedComments as $comment){
            $user = User::find()->where(['id' => $comment->author_id])->one();
            $comments = Comments::find()->where(['id' => $comment->comment_id])->one();
            $userNameStart = '<div class="mainpic"><div class="picture">';
            $userName = '<a href="'.Yii::$app->urlManager->createUrl(["user/view", "id" => $user->id]).'" title="Информация о '.Html::encode($user->username).'">
            <img src="/frontend/web/images/users/'.$user->avatar.'" alt="'.Html::encode($user->username).' аватар" title="Информация о '.Html::encode($user->username).'" class="imagecache imagecache-50x50"/></a>';
            $dateComment = HtmlPurifier::process(Yii::$app->formatter->asDate($comments->create_date, 'd MMMM yyyy'));
            $userDate = '<div class="created">'.$dateComment.'</div>';
            $userRatingStart = '<div class="userinfo-rating">
                                    <div class="user"><a href="'.Yii::$app->urlManager->createUrl(["user/view", "id" => $user->id]).'">'.Html::encode($user->username).'</a></div>';
            $userRatingEnd = '<div class="views-field-field-starz1-rating">
                                        <div class="fivestar-widget-static fivestar-widget-static-vote fivestar-widget-static-5 clear-block">
                                        '.$user->KarmaStatus.'
                                        </div></div>
                                </div>';
            $userNameEnd = '</div></div>';
            $userComment = '<div class="views-field-teaser"><p>'.Html::encode($comments->text).'</p></div>';
            $UserCommentsStart = '<li class="item first"><div class="review-node steaser">';
            $UserCommentsEnd = '</div></li>';

            $UserComments = $UserCommentsStart. $userNameStart.$userName.$userRatingStart.$userDate.$userRatingEnd.$userNameEnd.$userComment. $UserCommentsEnd;
            echo $UserComments;
        }
    }

    public function addComments(){
        if (Yii::$app->user->isGuest) { echo 'Зарегистрируйся, чтобы оставить свой комментарий.';}
        else{
            $com = new Comments();
        $form = ActiveForm::begin();
        echo $form->field($com, 'text')->textarea(['rows' => 6, 'maxlength' => true]);
        echo '<div class="form-group">';
        echo Html::submitButton('Отправить', ['class' => 'btn btn-success']);
        echo '</div>';
        ActiveForm::end();
            }
    }

    public function getFormSize(){
        $dirname = __DIR__.'/../web/files/'; // указываем полный путь до папки или файла $dirname = __DIR__.'/../../web/files/';
        $size = dir_size($dirname); //заносим в переменную размер папки или файла
        $formSize = format_size($size); //форматируем вывод
        echo $formSize;

        // функция для просмотра всех подпапок и всех вложенных файлов
        function dir_size($dirname) {
            $totalsize=0;
            if ($dirstream = @opendir($dirname)) {
                while (false !== ($filename = readdir($dirstream))) {
                    if ($filename!="." && $filename!="..")
                    {
                        if (is_file($dirname."/".$filename))
                            $totalsize+=filesize($dirname."/".$filename);

                        if (is_dir($dirname."/".$filename))
                            $totalsize+=dir_size($dirname."/".$filename);
                    }
                }
            }
            closedir($dirstream);
            return $totalsize;
        }
        // функция форматирует вывод размера
        function format_size($size){
            $metrics[0] = 'байт';
            $metrics[1] = 'Кбайт';
            $metrics[2] = 'Мбайт';
            $metrics[3] = 'Гбайт';
            $metrics[4] = 'Тбайт';
            $metric = 0;
            while(floor($size/1024) > 0){
                ++$metric;
                $size /= 1024;
            }
            $ret =  round($size,1)." ".(isset($metrics[$metric])?$metrics[$metric]:'??');
            return $ret;
        }
    }
}