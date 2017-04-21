<?php

use yii\widgets\ListView;
?>

    <div class="container white">
<br>
<?= ListView::widget([
    'dataProvider' => $listDataProvider,
    'itemView' => '_list',
    'options' => [
        'tag' => 'div',
        'class' => 'jumbotron',
    ],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'list-group-item',
    ],
    'pager' => [
        'firstPageLabel' => 'Первая',
        'lastPageLabel' => 'Последняя',
        'nextPageLabel' => '>>',
        'prevPageLabel' => '<<',
        'maxButtonCount' => 5,
    ],

    'emptyText' => '<b>Список пользователей пуст</b>.',
    'summary' => '<div class="summary">Показано {count} из {totalCount} пользователей.</div>'
]);
?>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">