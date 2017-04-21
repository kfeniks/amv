<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\News */
$this->title = Html::encode($video_name->title);
$model->counters;
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
                <p>Скачивание начнется само через 5 секунд. Если этого не произошло обновите страницу или обратитесь к администратору сайта.</p>
                <p>Ссылка: <a href="<?=$model->direct_url?>" role="button">Cсылка</a></p>

                <p>Формат id: <?= $model->format_id ?></p>
                <p>Кодек аудио id: <?= $model->codec_audio_id ?></p>
                <p>Кодек видео id: <?= $model->codec_vid_id ?></p>
                <p>Размер: <?= $model->filesize ?> мбайт</p>
                <p><?= Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy') ?></p>
                <p>Скачиваний: <?= $model->load_count ?></p>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








