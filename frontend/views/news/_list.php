<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>


    <h2><?= Html::encode($model->title) ?></h2>
<img src="/frontend/web/images/posts/<?= $model->img ?>" alt="<?= $model->title ?>" align="left"
     vspace="5" hspace="5" />
<p class="lead"><?= HtmlPurifier::process($model->intro_text) ?></p>
<p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["news/view", "id" => $model->id])?>" role="button">Подробнее</a></p>

