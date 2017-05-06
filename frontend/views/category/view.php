<?php

use yii\widgets\ListView;

?>
<div class="container-fluid">

    <!-- Plan -->
    <div class="row tm-section" id="tm-section-3">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center"><div class="container white">
                <h2 class="tm-section-title">Все AMV клипы в категории "<?=$catName?>"</h2>
                <p class="tm-section-subtitle">
                    Лучший способ научиться делать отличные аниме клипы - это понять, как сделали шедевр другие.
                    Поэтому предлагаем вам насладиться просмотром лучших amv работ по мнению наших критиков.
                </p>
            </div></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <?= ListView::widget([
                'dataProvider' => $listDataProvider,
                'itemView' => '_amv',
                'layout'=>"{summary}\n{items}",

                'pager' => [
                    'firstPageLabel' => 'Первая',
                    'lastPageLabel' => 'Последняя',
                    'nextPageLabel' => '>>',
                    'prevPageLabel' => '<<',
                    'maxButtonCount' => 5,
                ],

                'options' => [
                    'tag' => 'div',
                    'class' => 'tm-plan-boxes-container',
                    'id' => 'news-list',],
                'itemOptions' => [
                    'tag' => 'div',
                    'class' => 'clipstyle',
                ],
                'emptyText' => '<b>Список клипов пуст</b>.',
                'summary' => '<div class="container white">Найдено клипов: {totalCount}.</div><br>'
            ]);
            ?>
        </div>
        <div class="text-xs-center">
            <?= \yii\widgets\LinkPager::widget([
                'pagination'=>$listDataProvider->pagination,
            ]);?></div>
    </div>
    <div class="text-xs-center"><a href="<?=Yii::$app->urlManager->createUrl(["category/index"])?>" class="tm-bg-green-1 tm-btn-rounded tm-btn-green">Все категории</a></div>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
