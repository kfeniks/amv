<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */
$this->title = $model->title;
$model->updateCounters(['hits' => 1]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => 'Описание'
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => 'Ключи мета'
]);
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <img src="<?= $model->img ?>" alt="<?= $model->title ?>" align="left"
                     vspace="5" hspace="5" />
                <p><?= $model->full_text ?></p>
                <p><?= $model->date ?></p>
                <p>Просмотров: <?= $model->hits ?></p>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








