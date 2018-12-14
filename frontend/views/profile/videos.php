<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
$this->title = 'Мои клипы AMV.PP.UA';
//$bro = $model->category_id;
?>

<div class="container white">
    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1><?=Yii::$app->user->identity->name?>, добро пожаловать в раздел управления ваших амв клипов!</h1>
        <p class="lead">Создать, редактировать, смотреть статистику AMV. </p>

    </div>

    <div class="row tron">
        <div class="col-lg-4">
            <h2>Добавить</h2>
            <p>новый клип</p>
            <p><a class="btn btn-primary" href="<?=Yii::$app->urlManager->createUrl(["profile/create"])?>" role="button">Создать &raquo;</a></p>
        </div>

    </div>

    <div class="tm-bg-green-3 home">

        <h3>Ваши клипы</h3>
        <p>Здесь отображаются <strong>ваши amv клипы</strong>. Подробнее, как их добавить, вы можете прочесть в руководстве.</p>
        <?= ListView::widget([
            'dataProvider' => $listDataProvider,
            'itemView' => '_videos',
            'options' => [
                'tag' => 'div',
                'class' => '',
            ],
            'itemOptions' => [
                'tag' => 'div',
                'class' => 'row',
            ],
            'pager' => [
                'firstPageLabel' => 'Первая',
                'lastPageLabel' => 'Последняя',
                'nextPageLabel' => '>>',
                'prevPageLabel' => '<<',
                'maxButtonCount' => 10,
            ],


            'emptyText' => '<b>Список клипов пуст</b>.',
            'summary' => 'Всего клипов: {totalCount}.'
        ]);
        ?>
    </div>

</div>


<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">