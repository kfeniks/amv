<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = 'Create Videos Info';
$this->params['breadcrumbs'][] = ['label' => 'Create Videos', 'url' => ['create']];
$this->params['breadcrumbs'][] = 'Create Videos Info';
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