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
                <h1><?= Html::encode($this->title) ?></h1>
            </div>
            <div class="panel-body">

                <?= $this->render('_form', [
                    'model' => $model,
                    'selectedCategory' => $selectedCategory,
                    'category' => $category,
                ]) ?>
            </div>
        </div>
    </div>

</div>