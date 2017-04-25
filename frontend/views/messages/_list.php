<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<p class="lead">От <a href="<?=Yii::$app->urlManager->createUrl(["user/view",
        "id" => $model->id])?>"><?= Html::encode($model->profile->username) ?></a> <a href="<?=Yii::$app->urlManager->createUrl(["messages/view", "id" => $model->id])?>" >
        "<?= HtmlPurifier::process($model->subject) ?>"</a> <?= $model->CheckStatus?></p>

