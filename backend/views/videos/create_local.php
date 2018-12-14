<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Create Local';
$this->params['breadcrumbs'][] = ['label' => 'Create Videos', 'url' => ['create']];
$this->params['breadcrumbs'][] = 'Create Local';

?>

<div class="view-top">
    <div class="panel2 panel-success">
        <div class="panel-heading">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">

            <?= $this->render('_upload_local', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>