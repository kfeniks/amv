<?php

use yii\widgets\ListView;
use yii\helpers\Html;
$title="Мои личные сообщения";
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
    'emptyText' => 'Список пуст',
    'summary' => '<p>Всего у вас {totalCount} PM.</p>'
]);
?>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
