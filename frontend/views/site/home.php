<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\helpers\HtmlPurifier;
use frontend\models\Messages;
use frontend\models\Usernews;

$this->title = 'Главная страница AMV.PP.UA';
?>

<div class="container white">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Jumbotron -->
    <div class="jumbotron tron backgr">
        <h1><?=Yii::$app->user->identity->name?>, добро<br>пожаловать в<br>главный раздел пользователя!</h1>
        <p class="lead">Мы поможем вам на сайте, и вы сможете создавать<br>хорошие аниме клипы. Если вы хотите прочесть<br>руководство сейчас, нажмите на кнопку ниже</p>
        <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["site/homefaqs"])?>" role="button">Начни AMV сейчас!</a></p>
    </div>

    <!-- Example row of columns -->
    <div class="row tron">
        <div class="col-lg-4">
            <h2>Поиск по AMV клипам</h2>
            <p>Вы можете воспользоваться нашим расширенным поиском по аниме клипам. Вам будут доступны возможности фильтра по категориям. </p>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["category/index"]);?>" role="button">Начать поиск &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Ваш профиль</h2>
            <p>Откройте ваш профиль, чтобы обновить вашу контактную информацию или добавить новую. </p>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["profile/index"]);?>" role="button">Открыть профиль &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Ваши клипы</h2>
            <p>Добавляйте ваши новые амв клипы или редактируй старые. А еще можно посмотреть статистику.</p>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["profile/videos"])?>" role="button">Подбробнее &raquo;</a></p>
        </div>
    </div>

</div>

<?php
if($downloads){ ?>
    <div class="container white home">

        <h3>У вас есть клипы без вашей оценки</h3>
        <p>Здесь отображаются <strong>скачанные клипы</strong>, если вы еще не дали им оценки. Помогите нам делать лучше клипы!</p>
        <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["downloads/index"])?>" role="button">перейти к оцениванию</a></p>
    </div>
<?php } else echo '';?>
<?php
if($messages_user){ ?>
<div class="container white home">

    <h3>У вас есть непрочитанные сообщения</h3>
    <p>Здесь отображаются <strong>важные сообщения</strong>. Будьте в гуще событий нашего комьюнити, не упускайте шанс стать одним из нас.</p>
    <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["messages/index"])?>" role="button">открыть сообщения</a></p>
</div>
<?php } else echo '';?>
                    <div class="container white home">

                        <h3>Важные новости</h3>
                        <p>Здесь отображаются <strong>важные новости</strong>. Будьте в гуще событий нашего комьюнити, не упускайте шанс стать одним из нас.</p>
                        <?php if($usernews){
                        foreach ($usernews as $news){ ?>
                        <div class="row">
                            <div class="col-md-3"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($news->date_create, 'd MMMM yyyy'))  ?></div>
                            <div class="col-md-6">
                                <a href="<?=Yii::$app->urlManager->createUrl(["usernews/view", "id" => $news->news_id])?>" role="button"><?= HtmlPurifier::process ($news->title);  ?></a>
                                <?php
                                if($news->isRelease()){ ?>
                                    <span class="badge badge-danger">важно</span>
                                <?php }?>
                            </div>
                        </div>
                        <?php }} ?>
                    </div>

                    <div class="container white home">

                        <h3>Лучший клип недели</h3>
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                    Здесь отображается <strong>лучший аниме клип недели</strong>. Учись у профи.
                                </h3>
                            </div>
<?=                             ListView::widget([
                                'dataProvider' => $listDataProvider,

                                'itemView' => '_amvweek',

                                'pager' => [
                                    'firstPageLabel' => 'Первая',
                                    'lastPageLabel' => 'Последняя',
                                    'nextPageLabel' => '>>',
                                    'prevPageLabel' => '<<',
                                    'maxButtonCount' => 5,
                                ],

                                'options' => [
                                    'tag' => 'div',
                                    'class' => '',
                                    'id' => 'news-list',],
                                'itemOptions' => [
                                    'tag' => 'div',
                                    'class' => '',
                                ],
                                'emptyText' => '<b>На этой неделе нет рекомендованных клипов</b>.',
                                'summary' => ''
                            ]);
                          ?>

                        </div>

                    </div>

                    <div class="container white home">

                            <h3>Ваши последние клипы</h3>
                            <p>Здесь отображаются 5 <strong>ваших последних доступных amv клипов</strong>. Подробнее, как их добавить и где найти остальные, вы можете прочесть в руководстве.</p>

                                <?php if($video_user){
                                    foreach ($video_user as $video){ ?>
                                <div class="row">
                                <div class="col-md-3 tm-bg-pink-3"><span class="btn btn-success"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></span></div>
                                <div class="col-md-6 tm-bg-blue-3">
                                    <a class="btn btn-info" href="<?=Yii::$app->urlManager->createUrl(["profile/videos_info/", "id" => $video->id])?>" role="button"><?= HtmlPurifier::process ($video->title);  ?></a>
                                    </div>
                                </div>
                                    <?php }} ?>

                    </div>

<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">