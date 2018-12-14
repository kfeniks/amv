<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Create Direct';
$this->params['breadcrumbs'][] = ['label' => 'Create Videos', 'url' => ['create']];
$this->params['breadcrumbs'][] = 'Create Direct';

?>

<div class="view-top">
    <div class="panel2 panel-success">
        <div class="panel-heading">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="panel-body">

            <?= $this->render('_upload_direct', [
                'model' => $model
            ]) ?>
        </div>
    </div>
</div>