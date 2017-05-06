<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Update Videos: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->id])?>"><h1><?= Html::encode($this->title) ?></h1></a>
            </div>
            <div class="panel-body">
                <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/update_videos_step1", "id" => $model->id])?>" role="button">Редактировать описание клипа</a></p>
                <?= $model->CheckLocal ?>
                <?= $model->CheckPreview ?>
                <?= $model->CheckDirect ?>
                <?= $model->CheckVideos ?>
            </div>
        </div>
    </div>

</div>
