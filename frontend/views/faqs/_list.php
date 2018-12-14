<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<p><a href="<?=Yii::$app->urlManager->createUrl(["faqs/view", "id" => $model->id])?>"><?= Html::encode($model->name) ?></a></p>
