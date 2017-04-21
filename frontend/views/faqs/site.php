<?php

use yii\widgets\ListView;
use yii\helpers\Html;
$title="Все вопросы про сайт";
?>
<div class="container white">
    <br>
    <h2><?= Html::encode($title) ?></h2>
    <?= ListView::widget([
        'dataProvider' => $listDataProvider,
        'itemView' => '_list',

        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
            'nextPageLabel' => '>>',
            'prevPageLabel' => '<<',
            'maxButtonCount' => 5,
        ],

        'options' => [
            'tag' => 'div',
            'class' => 'jumbotron',
            'id' => 'news-list',],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'news-item',
        ],
        'emptyText' => 'Список вопросов пуст',
        'summary' => '<p>Всего {totalCount} ответов в <b>Руководстве пользователя</b>.</p>'
    ]);
    ?>
    <p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["site/homefaqs"])?>" role="button">Вернуться назад</a>
    <a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["faqs/index"])?>" role="button">Все вопросы</a></p>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
