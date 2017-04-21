<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Руководство AMV.PP.UA';
?>

<div class="container white">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Jumbotron -->
    <div class="jumbotron backgr3">
        <h1><?=Yii::$app->user->identity->name?>, добро<br>пожаловать в<br>руководство<br>пользователя!</h1>
        <p class="lead">Здесь представлены большинство необходимых ответов, как пользоваться<br>сайтом,
        как загружать свои клипы, как зарабатывать рейтинг для профиля.</p>
    </div>

    <!-- Example row of columns -->
    <div class="row faqs">
        <div class="col-lg-4">
            <h2>Все вопросы по сайту</h2>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["faqs/site"])?>" role="button">Подбробнее &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Вопросы по профилю</h2>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["faqs/profile"])?>" role="button">Подбробнее &raquo;</a></p>
        </div>
        <div class="col-lg-4">
            <h2>Вопросы по клипам</h2>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["faqs/amv"])?>" role="button">Подбробнее &raquo;</a></p>
        </div>
    </div>

</div>


<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">