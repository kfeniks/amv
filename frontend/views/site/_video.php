<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$text = mb_substr($video->comments, 0, 100).'...';
?>

<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-table-col">

    <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $video->id])?>" ><?=Html::encode($video->user->username); ?> - <?= Html::encode($video->title) ?></a></p>

</div>