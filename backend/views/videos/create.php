<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Create Videos';
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Create';
?>
<div class="user-update">

    <div class="view-top">
        <div class="panel2 panel-success">
            <div class="panel-heading">
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">
                <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/create_videos"])?>" role="button">Создать описание клипа</a></p>
                <?= $model->CheckLocal ?>
                <?= $model->CheckPreview ?>
                <?= $model->CheckDirect ?>
                <?= $model->CheckVideos ?>
            </div>
        </div>
    </div>

</div>