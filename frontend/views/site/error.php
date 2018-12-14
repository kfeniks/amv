<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>

<div class="container white">
     <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Ошибка возникла при обработке страницы.
    </p>
    <p>
        Пожалуйста, напишите нам, если видите эту страницу. Спасибо.
    </p>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
