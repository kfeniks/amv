<?php
use yii\helpers\HtmlPurifier;
use yii\widgets\LinkPager;
/* @var $this yii\web\View */

$this->title = 'Админ-панель AMV.PP.UA';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?= $countVideos ?></h3>

                <p>Клипов в базе</p>
            </div>
            <div class="icon">
                <i class="ion ion-film-marker"></i>
            </div>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
                <h3><?= $commentCount ?></h3>

                <p>Комментариев в базе</p>
            </div>
            <div class="icon">
                <i class="ion ion-chatbubble-working"></i>
            </div>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?= $countUsers ?></h3>

                <p>Пользователей в базе</p>
            </div>
            <div class="icon">
                <i class="ion ion-person-add"></i>
            </div>

        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <?php
                $ipUser->Ipmulti;
                ?>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>

        </div>
    </div>
    <!-- ./col -->
</div>
<!-- /.row -->
<!-- Main row -->
<?php
if(!$model == null){ ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">У вас есть клипы без одобрения</h3>
        </div>
        <div class="box-body">
            <?php foreach ($model as $video){ ?>
                <div class="row">
                    <div class="col-md-3"><i class="fa fa-clock-o"></i> <?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                    <div class="col-md-3"><i class="fa fa-user"></i> <?=  $video->user->username ?></div>
                    <div class="col-md-6">
                        <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $video->id])?>" role="button"><i class="fa  fa-caret-square-o-right"></i> <?= HtmlPurifier::process ($video->title);  ?></a>

                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /.box-body -->
    </div>
<?php } else echo '';?>


<?php
if(!$local == null){ ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">У вас есть local без одобрения</h3>
        </div>
        <div class="box-body">
            <?php foreach ($local as $video){ ?>
                <div class="row">
                    <div class="col-md-3"><i class="fa fa-clock-o"></i> <?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                    <div class="col-md-3"><i class="fa fa-user"></i> <?=  $video->user->username ?></div>
                    <div class="col-md-6">
                        <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step2", "id" => $video->id])?>" role="button"><i class="fa  fa-caret-square-o-right"></i> <?= HtmlPurifier::process ($video->videos->title);  ?></a>

                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /.box-body -->
    </div>
<?php } else echo '';?>


<?php
if(!$preview == null){ ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">У вас есть preview без одобрения</h3>
        </div>
        <div class="box-body">
            <?php foreach ($preview as $video){ ?>
                <div class="row">
                    <div class="col-md-3"><i class="fa fa-clock-o"></i> <?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                    <div class="col-md-3"><i class="fa fa-user"></i> <?=  $video->user->username ?></div>
                    <div class="col-md-6">
                        <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step3", "id" => $video->id])?>" role="button"><i class="fa  fa-caret-square-o-right"></i> <?= HtmlPurifier::process ($video->videos->title);  ?></a>

                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- /.box-body -->
    </div>
<?php } else echo '';?>

<?php
if(!$direct == null){ ?>
<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">У вас есть direct без одобрения</h3>
    </div>
    <div class="box-body">
        <?php foreach ($direct as $video){ ?>
            <div class="row">
                <div class="col-md-3"><i class="fa fa-clock-o"></i> <?= HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy'))  ?></div>
                <div class="col-md-3"><i class="fa fa-user"></i> <?=  $video->user->username ?></div>
                <div class="col-md-6">
                    <a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step4", "id" => $video->id])?>" role="button"><i class="fa  fa-caret-square-o-right"></i> <?= HtmlPurifier::process ($video->videos->title);  ?></a>

                </div>
            </div>
        <?php } ?>
    </div>
    <!-- /.box-body -->
</div>
<?php } else echo '';?>

<?php
if(!$vidcomments == null){ ?>
<!-- Chat box -->
<div class="box box-success">
    <div class="box-header">
        <i class="fa fa-comments-o"></i>

        <h3 class="box-title">Последние комментарии к клипам</h3>

    </div>
    <div class="box-body chat" id="chat-box">
        <?php foreach ($vidcomments as $comment){ ?>
           <? $commentsBody = \frontend\models\Comments::findOne($comment->comment_id); ?>
            <? $commentsUser = \frontend\models\User::findOne($comment->author_id); ?>
        <!-- chat item -->
        <div class="item">
            <img src="/frontend/web/images/users/<?= $commentsUser->avatar ?>" alt="user image" class="online">

            <p class="message">
                <a href="/videos/<?= $comment->videos_id ?>.html" class="name" target="_blank">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=  HtmlPurifier::process(Yii::$app->formatter->asDate($commentsBody->create_date, 'd MMMM yyyy')) ?></small>
                    <i class="fa fa-user"></i> <?=  $commentsUser->username ?>
                </a>
                <?=  HtmlPurifier::process ($commentsBody->text) ?>
            </p>
        </div>
        <!-- /.item -->
        <?php } ?>
        <? echo LinkPager::widget([
            'pagination' => $vidcommentsPages,
        ]); ?>
    </div>
    <!-- /.chat -->
<?php } else echo '';?>
<!-- /.row (main row) -->
