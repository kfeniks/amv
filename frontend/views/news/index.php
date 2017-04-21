<?php

use yii\widgets\ListView;
?>
<div class="container white">
    <br>
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
]);
?>
    <img src="/frontend/web/img/res-min.jpg" />
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
