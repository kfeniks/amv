<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Videos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Videos', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            [
                'label' => 'Автор',
                'attribute'=>'user.username',
            ],
            [
                'attribute'=>'is_recommended',
                'format' => 'raw',
                'value' => function($data){ return $data->NameRecommended;}
            ],
            [
                'attribute'=>'opinion_id',
                'format' => 'raw',
                'value' => function($data){ return $data->NameOpinion;}
            ],
            [
                'attribute'=>'availability',
                'format' => 'raw',
                'value' => function($data){ return $data->NameAvailability;}
            ],
            [
                'attribute'=>'status',
                'format' => 'raw',
                'value' => function($data){ return $data->NameStatus;}
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
