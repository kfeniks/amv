<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="row-vid">
    <div class="col-md-3 tm-bg-pink-3"><span class="btn btn-success"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></span></div>
    <div class="col-md-6 tm-bg-blue-3"><a class="btn btn-info" href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->id])?>" role="button"><?= Html::encode($model->title) ?></a></div>
</div>