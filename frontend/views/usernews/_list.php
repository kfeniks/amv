<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>


    <h2><?= Html::encode($model->title) ?></h2>
<img src="/frontend/web/images/news/<?= $model->img ?>" alt="<?= $model->title ?>" align="left"
     vspace="5" hspace="5" class="img-rounded" />
<p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["news/view", "id" => $model->news_id])?>" role="button">Подробнее</a></p>
<div class="clearfix"></div>

