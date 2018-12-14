<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения для пользователей';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <p>
        <?= Html::a('Создать соощение', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Написать всем', ['all'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'label' => 'Пользователю',
                'attribute'=>'user.username',
            ],
            'subject:ntext',
            'date_time:datetime',
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){ return $data->NameStatus;}
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
