<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */
$this->title = 'Пользователь '. $model->username;
?>

<div class="container white">
    <br>
    <div class="view-top">
    <div class="panel2 panel-success">
        <div class="panel-heading">
            <h1><?= Html::encode($model->username) ?></h1>
        </div>
        <div class="panel-body">
            <img src="/frontend/web/images/users/<?= $model->avatar ?>" alt="<?= $model->username ?>" align="left"
                 vspace="5" hspace="5" />
            <!--noindex-->
            <p>Имя: <?= $model->name ?></p>
            <p>Дата регистрации: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
            <p>Емеил: <?= $model->email ?></p>
            <p>Статус: <?= $model->profile_type ?></p>
            <p>Пол: <?= $model->SexName ?>.</p>
            <p>День Рождения: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->birthdate_day, 'd MMMM yyyy')) ?></p>
            <p>Страна: <?= $model->CountryName ?></p>
            <p>Город: <?= $model->city ?></p>
            <p>Сайт: <a href="<?= $model->website ?>" target="_blank"><?= $model->website ?></a></p>
            <p>Обо мне: <?= $model->about ?></p><!--/noindex-->
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








