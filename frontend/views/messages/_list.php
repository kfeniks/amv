<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\models\Messages;
?>

<p class="lead">От кого: <?= HtmlPurifier::process($model->user_id_from) ?></p>
<p class="lead">Тема: <?= HtmlPurifier::process($model->subject) ?> <?php if ($model->status == Messages::STATUS_PENDING)
        echo '<span class="badge badge-success">непрочитанное</span>';
    else  echo '';
    ?></p>
<p><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["messages/view", "id" => $model->id])?>" role="button">прочесть</a></p>

