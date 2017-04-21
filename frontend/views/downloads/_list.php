<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\models\Userdownloads;
?>

<p class="lead"><a href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => $model->user_id])?>" ><b><?= HtmlPurifier::process($model->UserName) ?></b></a> -
    <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->videos_id])?>" ><?= HtmlPurifier::process($model->VideoName) ?></a> <?php $model->Status;?></p>
<p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["downloads/view", "id" => $model->id])?>" role="button">оценить</a></p>

