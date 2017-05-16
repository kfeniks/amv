<?php
use yii\helpers\HtmlPurifier;
use backend\models\Ip;
/* @var $this yii\web\View */

$this->title = 'Админ-панель AMV.PP.UA';
?>
<div class="site-index">

    <div class="jumbotron">

        <p><a href="<?=Yii::$app->urlManager->createUrl(["user/index"])?>" class="btn btn-lg btn-success">Редактировать пользователей</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["news/index"])?>" class="btn btn-lg btn-success">Редактировать Новости (на главной)</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["usernews/index"])?>" class="btn btn-lg btn-success">Редактировать Новости (профиль)</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/index"])?>" class="btn btn-lg btn-success">Редактировать Видео</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["faqs/index"])?>" class="btn btn-lg btn-success">Редактировать Faqs</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["ip/index"])?>" class="btn btn-lg btn-success">Ip</a></p>
        <p><a href="<?=Yii::$app->urlManager->createUrl(["usersmessages/index"])?>" class="btn btn-lg btn-success">Сообщения</a></p>
    </div>

    <div class="body-content">

                <?php
                $ipUser->Ipmulti;
                ?>

        <?php
        if(!$model == null){ ?>
            <div class="container white home">

                <h3>У вас есть клипы без одобрения</h3>

                <?php foreach ($model as $video){ ?>
                <div class="row">
                    <div class="col-md-3"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                    <div class="col-md-3"><?=  $video->user->username ?></div>
                    <div class="col-md-6">
                        <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $video->id])?>" role="button"><?= HtmlPurifier::process ($video->title);  ?></a>

                    </div>
                </div>
                <?php } ?>
            </div>
        <?php } else echo '';?>


        <?php
        if(!$local == null){ ?>
            <div class="container white home">

                <h3>У вас есть local без одобрения</h3>

                <?php foreach ($local as $video){ ?>
                    <div class="row">
                        <div class="col-md-3"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                        <div class="col-md-3"><?=  $video->user->username ?></div>
                        <div class="col-md-6">
                            <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step2", "id" => $video->id])?>" role="button"><?= HtmlPurifier::process ($video->videos->title);  ?></a>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else echo '';?>


        <?php
        if(!$preview == null){ ?>
            <div class="container white home">

                <h3>У вас есть preview без одобрения</h3>

                <?php foreach ($preview as $video){ ?>
                    <div class="row">
                        <div class="col-md-3"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                        <div class="col-md-3"><?=  $video->user->username ?></div>
                        <div class="col-md-6">
                            <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step3", "id" => $video->id])?>" role="button"><?= HtmlPurifier::process ($video->videos->title);  ?></a>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else echo '';?>


        <?php
        if(!$direct == null){ ?>
            <div class="container white home">

                <h3>У вас есть direct без одобрения</h3>

                <?php foreach ($direct as $video){ ?>
                    <div class="row">
                        <div class="col-md-3"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                        <div class="col-md-3"><?=  $video->user->username ?></div>
                        <div class="col-md-6">
                            <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step4", "id" => $video->id])?>" role="button"><?= HtmlPurifier::process ($video->videos->title);  ?></a>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else echo '';?>


        <?php
        if(!$vidcomments == null){ ?>
            <div class="container white home">

                <h3>Последние 20 комментариев к клипам</h3>

                <?php foreach ($vidcomments as $comment){ ?>
                    <div class="row">
                        <div class="col-md-3">Автор: <?=  $comment->author_id ?></div>
                        <div class="col-md-3">Коммент: <?=  $comment->comment_id ?></div>
                        <div class="col-md-6">
                            Видео: <a href="/videos/<?= $comment->videos_id ?>.html" role="button"><?= HtmlPurifier::process ($comment->videos_id);  ?></a>

                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else echo '';?>



        <?php
        if(!$comments == null){ ?>
            <div class="container white home">

                <h3>Последние 20 записей комментариев</h3>

                <?php foreach ($comments as $comment){ ?>

                        <div><?=  HtmlPurifier::process(Yii::$app->formatter->asDate($comment->create_date, 'd MMMM yyyy')) ?></div>
                        <div><?=  HtmlPurifier::process ($comment->text) ?></div><br>


                <?php } ?>
            </div>
        <?php } else echo '';?>

    </div>
</div>
