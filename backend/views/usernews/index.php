<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Новости профиля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Create UserNews', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title:ntext',
            'date_create:datetime',
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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
