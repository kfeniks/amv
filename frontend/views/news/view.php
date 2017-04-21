<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model frontend\models\News */
$this->title = $model->title;
$model->updateCounters(['hits' => 1]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_desc
]);
$this->registerMetaTag([
        'name' => 'keywords',
        'content' => $model->meta_key
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
            <img src="/frontend/web/images/posts/<?= $model->img ?>" alt="<?= $model->title ?>" align="left"
                 vspace="5" hspace="5" />
            <p><?= HtmlPurifier::process($model->full_text) ?></p>
            <p><?= Yii::$app->formatter->asDate($model->date, 'd MMMM yyyy') ?></p>
            <p>Просмотров: <?= $model->hits ?></p>
        </div>
    </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








