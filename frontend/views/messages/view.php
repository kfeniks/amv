<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\DetailView;
use frontend\models\Messages;

/* @var $this yii\web\View */
/* @var $model frontend\models\Messages */
$this->title = 'Сообщение от '. $model->user_id_from;
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Сообщение от <?= Html::encode($model->user_id_from) ?></h1>
            </div>
            <div class="panel-body">

                <p>Тема: <?= $model->subject ?></p>

                <p>Когда отправлено: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->date_time, 'd MMMM yyyy')) ?></p>
                <p>Текст сообщения:</p>
                <p><?= $model->message ?><br></p>
                <p>Ответить...</p>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
<?php
$id = $model->id;
Yii::$app->db->createCommand()->update('users_messages', ['status' => Messages::STATUS_APPROVED], 'id=:id')->bindParam(':id', $id)->execute();
?>







