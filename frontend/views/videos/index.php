<?php

use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="container-fluid">

    <!-- Plan -->
    <div class="row tm-section" id="tm-section-3">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center"><div class="container white">
            <h2 class="tm-section-title">Все AMV клипы</h2>
            <p class="tm-section-subtitle">
                Лучший способ научиться делать отличные аниме клипы - это понять, как сделали шедевр другие.
                Поэтому предлагаем вам насладиться просмотром лучших amv работ по мнению наших критиков.
            </p>
                <div class="vcenter">
                <div class="col-xs-12">
                    <?php $form = ActiveForm::begin([
                        'action' => ['index'],
                        'method' => 'get',
                    ])?>

                    <table>
                        <tr>
                            <td>
                                <?= $form->field($question, 'q')->textInput(['maxlength' => true]) ?>
                            </td>
                            <td>
                                <input class="searchButton" title="Найти" alt="Найти" type="image" src="/frontend/web/images/button_search.png">
                            </td>
                        </tr>
                    </table>

                    <?php // Html::submitButton('Поиск', ['class' => 'btn btn-primary'])?>

                    <?php ActiveForm::end(); ?>
                </div></div>
            </div></div>
        <div id="primary" class="vce-main-content">

<?= ListView::widget([
    'dataProvider' => $listDataProvider,
    'itemView' => '_list',
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
        'class' => 'vce-module-columns',
        'id' => 'news-list',],
    'itemOptions' => [
        'tag' => 'div',
        'class' => 'main-box vce-border-top main-box-half',
    ],
    'emptyText' => '<b>Список клипов пуст</b>.',
    'summary' => '<div class="container white">Всего клипов: {totalCount}.</div><br>'
]);
?>
    </div>
        <div class="clearfix"></div>
        <div class="text-xs-center">
            <?= \yii\widgets\LinkPager::widget([
                'pagination'=>$listDataProvider->pagination,
            ]);?></div>
</div>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
