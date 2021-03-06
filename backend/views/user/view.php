<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'name',
            'profile_type',
            [
                'attribute'=>'avatar',
                'value'=>('/frontend/web/images/users/' . $model->avatar),
                'format' => ['image',['width'=>'100','height'=>'100']],
            ],
            [
                'attribute'=>'sex_id',
                'format' => 'raw',
                'value' => function($data){ return $data->sex->name;}
            ],
            'birthdate_day:datetime',
            [
                'attribute'=>'country_id',
                'format' => 'raw',
                'value' => function($data){ return $data->country->name;}
            ],
            'city',
            'website',
            'about',
            'email:email',
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){ return $data->Status;}
            ],
            'created_at:datetime',
            'updated_at:datetime',
            'karma',
        ],
    ]) ?>
    <?=$model->ip ?>

</div>
