<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */
$this->title = $model->title;
$model->updateCounters(['hits' => 1]);
$model->user->updateCounters(['karma' => 1]);
$this->registerMetaTag([
    'name' => 'description',
    'content' => $model->meta_desc
]);
$this->registerMetaTag([
        'name' => 'keywords',
        'content' => $model->meta_key
]);
?>

<div class="container white">
    <br>
    <div class="view-top">
    <div class="panel2 panel-success">
        <div class="panel-heading">
            <h1><a href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => $model->user->id])?>">
                    <?php echo Html::encode($model->user->username); ?></a> - <?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">
            <p><?=$model->Rating?></p>

            <img src="/frontend/web/files/<?= Html::encode($model->img) ?>" style="width: 500px; height: 300px;" alt="<?= Html::encode($this->title) ?>" align="left"
                 vspace="5" hspace="5" />
            <p><b>Аниме:</b> <?=Html::encode($model->anime)?></p>
            <p><b>Музыка:</b> <?=Html::encode($model->song)?></p>
            <p><b>Категории:</b>
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
            </p>
            <div class="clearfix"></div>
            <!--noindex-->
                <?php if($model->youtube != Null){?><p><b>Видео на ютубе</b>: <a href="https://youtu.be/<?=Html::encode($model->youtube)?>" target="_blank">смотреть на ютубе</a></p>
                    <?php } else {echo '';} ?><!--/noindex-->
            <p><b>Длительность:</b> <?=  HtmlPurifier::process(Yii::$app->formatter->asTime($model->duration, 'mm:ss')) ?></p>
            <p><b>Описание:</b></p>
            <p><?= HtmlPurifier::process ($model->comments) ?></p>
            <p><b>Дата премьеры:</b> <?=  HtmlPurifier::process(Yii::$app->formatter->asDate($model->premiered, 'd MMMM yyyy')) ?></p>
            <p><b>Добавлен:</b> <?=  HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
            <p><b>Просмотров:</b> <?= Html::encode($model->hits) ?></p>
            <p><b>Скачиваний:</b> <?= Html::encode($model->alldownloads) ?></p>
            <p><b>Статус:</b> <?= Html::encode($model->siteOpinion()) ?></p>
            <?= HtmlPurifier::process($model->amvAwards()) ?>
            <p><b>Версия в хорошем качестве:</b>
                <?= $model->LinkLocal?>
            </p>
            <p><b>Версия в плохом качестве (preview):</b>
                <?= $model->LinkPreview?>
            </p>
            <p><b>Версия на другом хостинге:</b>
                <?= $model->LinkDirect?>
            </p>
            <img src="/frontend/web/img/heart_add.png" alt="heart add amv клип избранное" title="Добавить в избранное клип"
                 style="display: block; position: fixed; right:6px; top: 75%;" />
            <img src="/frontend/web/img/stop_sign.png" alt="stop sign amv клип пожаловаться" title="Пожаловаться на клип"
                 style="display: block; position: fixed; right:6px; top: 80%;" />
                    </div>
    </div>
    </div>

</div>
                <div class="container white martop">


                <div class="item-list"><ul class="list-comments">
                <?=$model->UserComments ?>
                        </ul></div>
                </div>

                <div class="container white martop">
                    <?php $model->addComments() ?>
                </div>


<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">








