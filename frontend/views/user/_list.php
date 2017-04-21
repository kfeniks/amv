<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>

<div class="row">

    <div class="col-xs-6 col-md-4"><img src="/frontend/web/images/users/<?= $model->avatar ?>" alt="<?= $model->username ?>" /></div>
    <div class="col-xs-6 col-md-4"><h2><?= Html::encode($model->username) ?></h2>
        <p class="lead"><?= HtmlPurifier::process(Yii::$app->formatter->asDate($model->created_at, 'd MMMM yyyy')) ?></p>
    </div>
    <div class="col-xs-6 col-md-4"><a class="btn btn-lg btn-success" href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => $model->id])?>" role="button">Посмотреть</a></div>


</div>

