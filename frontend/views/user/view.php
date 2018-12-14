<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
$this->title = 'Пользователь '. Html::encode($model->username);
?>

<div class="container white">
    <br>
    <div class="view-top">
    <div class="panel2 panel-success">
        <div class="panel-heading">
            <h1><?= Html::encode($model->username) ?></h1>
        </div>
        <div class="panel-body">
            <img src="/frontend/web/images/users/<?= $model->avatar ?>" alt="<?= Html::encode($model->username) ?>" align="left"
                 vspace="5" hspace="5" />
            <p>Имя: <?= Html::encode($model->name) ?></p>
            <p>Дата регистрации: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
            <p>Статус: <?= $model->profile_type ?></p>
            <?php if ($model->sex_id !== null){?>
                <p>Пол: <?= $model->sex->name ?>.</p>
            <?php } ?>
            <?php if ($model->birthdate_day !== null){?>
            <p>День Рождения: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->birthdate_day, 'd MMMM yyyy')) ?></p>
            <?php } ?>
            <?php if ($model->country_id !== null){?>
            <p>Страна: <?= $model->country->name ?></p>
            <?php } ?>
            <!--noindex-->
            <?php if ($model->city !== null){?>
            <p>Город: <?= Html::encode($model->city) ?></p>
            <?php } ?>
            <?php if ($model->website !== null){?>
            <p>Сайт: <a href="<?= Html::encode($model->website) ?>" target="_blank"><?= Html::encode($model->website) ?></a></p>
            <?php } ?>
            <?php if ($model->about !== null){?>
            <p>Обо мне: <?= HtmlPurifier::process($model->about) ?></p>
            <?php } ?>
            <!--/noindex-->
            <p>Карма: <?= $model->KarmaStatus ?>.</p>
            <p>Клипы автора:</p>
            <?= ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => '_videos',
                'options' => [
                    'tag' => 'div',
                    'class' => '',
                ],
                'itemOptions' => [
                    'tag' => 'div',
                    'class' => 'row',
                ],
                'pager' => [
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                    'nextPageLabel' => '>>',
                    'prevPageLabel' => '<<',
                    'maxButtonCount' => 10,
                ],


                'emptyText' => '<b>У автора пока нет клипов</b>.',
                'summary' => ''
            ]);
            ?>
        </div>
    </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








