<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model frontend\models\Userdownloads */
$this->title = 'Клип '. $model->videos_id.' от юзера '.$model->user_id;
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Оценивание клипа <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->videos_id])?>" ><?= HtmlPurifier::process($model->VideoName) ?></a></h1>
            </div>
            <div class="panel-body">

                <p>Автор: <a href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => $model->user_id])?>" ><b><?= HtmlPurifier::process($model->UserName) ?></b></a></p>

                <p>Когда скачано: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->create_date, 'd MMMM yyyy')) ?></p>
                <p>Дать оценку:</p>
                <?= $model->checkStatus()?>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">







