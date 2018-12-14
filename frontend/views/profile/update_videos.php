<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Редактировать клип: ' . $model->title;

?>
<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <a href="<?=Yii::$app->urlManager->createUrl(["profile/videos_info", "id" => $model->id])?>"><h1><?= Html::encode($this->title) ?></h1></a>
            </div>
            <div class="panel-body">
                <p><a href="<?=Yii::$app->urlManager->createUrl(["profile/update_videos_step1", "id" => $model->id])?>" role="button">Редактировать описание клипа</a></p>
                <?= $model->CheckLocal ?>
                <?= $model->CheckPreview ?>
                <?= $model->CheckDirect ?>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
