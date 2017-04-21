<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model frontend\models\Faqs */
$this->title = $model->name;
$model->updateCounters(['hits' => 1]);
?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1><?= Html::encode($model->name) ?></h1>
            </div>
            <div class="panel-body">
                <h3><?= HtmlPurifier::process($model->CatName) ?></h3>
                <p><?= HtmlPurifier::process($model->text) ?></p>
                <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["site/homefaqs"])?>" role="button">Вернуться назад</a></p>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">







