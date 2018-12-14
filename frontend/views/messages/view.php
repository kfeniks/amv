<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;


/* @var $this yii\web\View */
/* @var $model frontend\models\Messages */
$this->title = 'Сообщение от '. $model->profile->username;
$model->updateStatus();
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Сообщение от <a href="<?=Yii::$app->urlManager->createUrl(["user/view",
                        "id" => $model->id])?>"><?= Html::encode($model->profile->username) ?></a></h1>
            </div>
            <div class="panel-body">

                <p>Тема: <?= $model->subject ?></p>

                <p>Когда отправлено: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->date_time, 'd MMMM yyyy')) ?></p>
                <p>Текст сообщения:</p>
                <p><?= $model->message ?><br></p>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">







