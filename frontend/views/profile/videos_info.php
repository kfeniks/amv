<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;

$this->title = 'Клип '. $model->title;
?>

<div class="container white">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1><?=Yii::$app->user->identity->name?>, добро пожаловать в раздел статистики ваших амв клипов!</h1>
        <p class="lead">смотреть статистику амв. </p>
    </div>
    <?php
    $video_info = \frontend\models\Local::find()->where(['videos_id' => $model->id])->one();
    $direct_info = \frontend\models\Direct::find()->where(['videos_id' => $model->id])->one();
    $preview_info = \frontend\models\Preview::find()->where(['videos_id' => $model->id])->one();
    $opinion = \frontend\models\Opinion::find()->where(['id' => $model->opinion_id])->one();

    $user_info = \frontend\models\User::find()->where(['id' => $model->author_id])->one();
    ?>

    <div class="tm-bg-green-3 home">
        <img src="/frontend/web/files/<?= Html::encode($model->img) ?>" alt="<?= $model->title ?>" />
        <p>Название: <?= $model->title ?></p>
        <p>Дата создания: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
        <p>Аниме: <?= $model->anime ?></p>
        <p>Песня: <?= $model->song ?></p>
        <div class="floatleft"><b>Категории:</b></div>
            <?= ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => '_listcategory',

                'pager' => [
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                    'nextPageLabel' => '>>',
                    'prevPageLabel' => '<<',
                    'maxButtonCount' => 10,
                ],

                'options' => [
                    'tag' => 'div',
                    'class' => '',
                    'id' => 'news-list',],
                'itemOptions' => [
                    'tag' => 'div',
                    'class' => 'floatleft',
                ],
                'emptyText' => '<b>Список категорий пуст</b>.',
                'summary' => ''
            ]);
            ?>

        <div class="clearfix"></div>
        <p>Премьера клипа: <?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->premiered, 'd MMMM yyyy')) ?></p>
        <p>Доступность: <?php
           if ($model->availability == 1){ echo 'Отображается';}
           else{echo 'Заблокировано администратором';}
             ?></p>
        <p>Ссылки для скачивания:</p>
        <p><b>Версия в хорошем качестве:</b>
            <?= $model->LinkLocal?>
        </p>
        <p><b>Версия в плохом качестве (preview):</b>
            <?= $model->LinkPreview?>
        </p>
        <p><b>Версия на другом хостинге:</b>
            <?= $model->LinkDirect?>
        </p>
       <?php if($model->youtube != Null){?> <p><b>Видео на ютубе</b>: <a href="https://youtu.be/<?=Html::encode($model->youtube)?>" target="_blank">смотреть на ютубе</a></p>
            <?php } else {echo '<p><b>Видео на ютубе</b>: Cсылка на ютуб не указана.</p>';} ?>
        <p>Описание клипа:</p>
        <p><?= $model->comments ?></p>
        <p>Приватность: <?php
            if ($model->status == 1){ echo 'Доступно для просмотра (ваши настройки)';}
            else{echo 'Скрыто от других пользователей вами';}
            ?></p>
        <p>Оценка от сайта: <?= $opinion->opinion_name ?>. <?= $opinion->opinion_comments ?> </p>
        <p>Количество просмотров: <?= $model->hits ?></p>
        <p>Количество скачиваний: <?= $model->AllDownloads ?></p>
        <?php
        if ($model->award_week == 1){ ?>
        <p>Клип номинирован на звание "Лучший клип недели" по мнению критиков.</p>
        <?php }?>

        <?php
        if ($model->award_month == 1){ ?>
            <p>Клип номинирован на звание "Лучший клип месяца" по мнению критиков.</p>
        <?php }?>

    </div>

</div>


<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">