<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */
$model->ifMyClip();
Yii::$app->session->close();
Yii::$app->session->destroy();
$this->title = "Успешный результат";

?>

<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1>Добавление клипа. <?= Html::encode($model->title) ?>.</h1>
                <?= Html::encode($this->title) ?>
            </div>
            <div class="panel-body">
                <img src="/frontend/web/files/<?= $model->img ?>" alt="<?= $model->title ?>" />
                <p>Название: <?=Html::encode($model->title)?></p>
                <p>Автор: <?=Html::encode($user->username)?></p>
                <p>Аниме: <?=Html::encode($model->anime)?></p>
                <p>Песня: <?=Html::encode($model->song)?></p>
                <p>Категория: <?=Html::encode($сategory->cat_name)?></p>
                <p>Комментарий:</p> <p><?=Html::encode($model->comments)?></p>
                <p>Ссылка основной файл: <a href="<?=Yii::$app->urlManager->createUrl(["profile/viewlocal", "id" => $model->local_id])?>">ссылка</a></p>
                <?php if($model->preview_id =! Null){?>
                    <p>Ссылка превью файл: <a href="<?=Yii::$app->urlManager->createUrl(["profile/viewpreview", "id" => $model->preview_id])?>">ссылка</a></p>
                <?php } else {echo '<p>Превью файл не загружен.</p>';} ?>

                <?php if($model->direct_id =! Null){?>
                    <p>Ссылка внешний сервер: <a href="<?=Yii::$app->urlManager->createUrl(["profile/viewdirect", "id" => $model->direct_id])?>">ссылка</a></p>
                <?php } else {echo '<p>Внешняя ссылка на файл не указана.</p>';} ?>
                <?php if($model->youtube != Null){?>
                <p>Ссылка на ютуб: <a href="https://youtu.be/<?=Html::encode($model->youtube)?>">смотреть на ютубе</a></p>
                <?php } else {echo '<p>Cсылка на ютуб не указана.</p>';} ?>
                <p>Дата премьеры клипа: <?= Yii::$app->formatter->asDate($model->premiered, 'd MMMM yyyy') ?></p>
                <p>Клип добавлен: <?= Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy') ?></p>
                <p>Видимость: <?php
                    if($model->status != 0){echo 'показывать всем.';}
                    else{echo 'виден только мне.';}
                    ?>
                <p>Клип виден всем? <?php
                    if($model->availability != 0){echo 'Да, клип прошел модерацию.';}
                    else{echo 'Нет, клип еще не прошел модерацию.';}
                    ?>

            </div>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








