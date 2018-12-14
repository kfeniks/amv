<?php

use yii\helpers\Html;
use  yii\web\Session;

/* @var $this yii\web\View */
/* @var $model frontend\models\Local */
$this->title = Html::encode($model->videos->title);
$session = new Session;
$session->open();
if (Yii::$app->user->isGuest){}
else{$model->userdownloads;}
$model->counters;
$model->user->updateCounters(['karma' => 10]);
$model->refresh;
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Локальный файл для клипа <?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <p>Скачивание начнется само через 5-10 секунд. Если этого не произошло, обновите страницу или обратитесь к администратору сайта.</p>
                <p>Файл будет загружен в папку (по умолчанию), которая задана в браузере. Обычно это "Загрузки".</p>
                <p>Формат: <?= $model->formatName() ?></p>
                <p>Кодек аудио: <?= $model->CodecAudioName() ?></p>
                <p>Кодек видео: <?= $model->CodecVidName() ?></p>
                <p>Размер: <?= $model->file_size ?> мбайт</p>
                <p>Дата добавления: <?= Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy') ?></p>
                <p>Скачиваний: <?= $model->load_count ?></p>
                <br/><?php
                $check_url = Yii::$app->request->referrer;
                //Проверяем является ли сайт подлинным (http://amv...) или ссылку вставили в другой сайт
                $check_url_link = $check_url{7}.$check_url{8}.$check_url{9};
                if($check_url_link == 'amv'){ ?>
                    <p>Вернуться <a href="<?= (!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null) ?>">назад</a> к клипу.</p>
                <?php } else{
                    header('Location: '.Yii::$app->homeUrl);
                    exit;
                } ?>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








