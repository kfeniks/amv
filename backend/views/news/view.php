<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новость', 'url' => ['index']];
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
            [
                'attribute'=>'img',
                'value'=>('/frontend/web/images/posts/'. $model->img),
                'format' => ['image',['width'=>'300','height'=>'200']],
            ],
            'title:ntext',
            'meta_key:ntext',
            'meta_desc:ntext',
            [
                'attribute'=>'is_release',
                'format' => 'raw',
                'value' => function($data){ return $data->NameRelease;}
            ],
            [
                'attribute'=>'hide',
                'format' => 'raw',
                'value' => function($data){ return $data->NameStatus;}
            ],
            'hits',
            'date:datetime',
            'date_update:datetime',
            'intro_text:ntext',
            'full_text:ntext',

        ],
    ]) ?>
    <div class="clearfix"></div>

</div>
