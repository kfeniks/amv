<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$this->title = 'Пользователь '. Html::encode($model->username);
?>
<div class="container white">
    <br>
    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1><?= Html::encode($model->username) ?></h1>
            </div>
            <div class="panel-body trono">
                <img src="/frontend/web/images/users/<?= $model->avatar ?>" alt="<?= $model->username ?>" align="left"
                     vspace="5" hspace="5" />
                <!--noindex-->
                <p>Имя: <?= $model->name ?></p>
                <p>Дата регистрации: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
                <p>Емеил: <?= $model->email ?></p>
                <p>Статус: <?= $model->profile_type ?></p>
                <?php use frontend\models\Sex;
                $sex_user = Sex::find()->where(['id' => $model->sex_id])->one();
                ?>
                <p>Пол: <?= $model->SexName ?>.</p>
                <p>День Рождения: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->birthdate_day, 'd MMMM yyyy')) ?></p>
                <p>Страна: <?= $model->CountryName ?></p>
                <p>Город: <?= $model->city ?></p>
                <p>Сайт: <a href="<?= $model->website ?>"><?= $model->website ?></a></p>
                <p>Обо мне: <?= $model->about ?></p><!--/noindex-->
                    <p>Карма: <?= $model->KarmaStatus ?>.</p>

            </div>
            <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["profile/update"]);?>" role="button">Редактировать</a>
                <a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["profile/password-change"]);?>" role="button">Изменить пароль</a></p>
        </div>
    </div>

</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
