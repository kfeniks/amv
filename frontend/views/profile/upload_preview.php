<?php

use yii\helpers\Html;
use  yii\web\Session;


/* @var $this yii\web\View */
/* @var $model backend\models\User */
$videoid = Yii::$app->session->get('idVideo');
if ($videoid == Null) {
    header('Refresh: url=' . Yii::$app->urlManager->createUrl(["profile/create"]) . '');
}

$this->title = 'Добавление превью. Шаг 3';
?>
<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="jumbotron">
                <h1><?=Yii::$app->user->identity->name?>, добро пожаловать на 3 шаг добавления клипа <?php if ($videoid != Null){echo 'номер '. $videoid;} ?>!</h1>
                <p class="lead">Добавление превью файла клипа.</p>
                <p class="lead">Заполни форму ниже и нажми "отправить", либо пропусти этот шаг.</p>
            </div>
            <div class="panel-body">
                <?= $this->render('_upload_preview', [
                    'model' => $model
                ]) ?>
                <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["profile/upload_direct"])?>" role="button">Пропустить этот шаг</a></p>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">

