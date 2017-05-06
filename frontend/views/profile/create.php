<?php

use yii\helpers\Html;
use  yii\web\Session;


/* @var $this yii\web\View */
/* @var $model frontend\models\Profile */
$session = new Session;
$session->open();

$this->title = 'Добавление клипа. Шаг 1';
?>
<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
    <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="jumbotron">
                <h1><?=Yii::$app->user->identity->name?>, добро пожаловать на 1 шаг добавления клипа !</h1>
                <p class="lead">Заполни форму ниже и нажми "отправить".</p>
            </div>
            <div class="panel-body">
    <?= $this->render('_download', [
        'model' => $model,
        'category' => $category
    ]) ?>
            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">

