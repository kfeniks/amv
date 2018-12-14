<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\User */

$this->title = 'Update Direct: ' . $model->videos->title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->videos->title, 'url' => ['view', 'id' => Yii::$app->session->get('idVideo')]];
$this->params['breadcrumbs'][] = 'Update Direct';

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


