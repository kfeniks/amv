<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Videos', 'url' => ['index']];
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
                'label' => 'Автор',
                'attribute'=>'user.username',
            ],
            [
                'attribute'=>'img',
                'value'=>('/frontend/web/files/'. $model->img),
                'format' => ['image',['width'=>'300','height'=>'200']],
            ],
            'anime:ntext',
            'song:ntext',
            'duration:time',
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
            [
                'attribute'=>'award_week',
                'format' => 'raw',
                'value' => function($data){ return $data->NameAwardWeek;}
            ],
            [
                'attribute'=>'award_month',
                'format' => 'raw',
                'value' => function($data){ return $data->NameAwardMonth;}
            ],
            'youtube',
            'hits',
            'meta_key:ntext',
            'meta_desc:ntext',
            'premiered:datetime',
            'created_at:datetime',
            'updated_at:datetime',
            'comments:ntext',

        ],
    ]) ?>
    <div class="floatleft"><b>Категории:</b></div>
    <?= ListView::widget([
        'dataProvider' => $listDataProvider,
        'itemView' => '_listcategory',

        'pager' => [
            'firstPageLabel' => 'Первая',
            'lastPageLabel' => 'Последняя',
            'nextPageLabel' => '>>',
            'prevPageLabel' => '<<',
            'maxButtonCount' => 10,
        ],

        'options' => [
            'tag' => 'div',
            'class' => '',
            'id' => 'news-list',],
        'itemOptions' => [
            'tag' => 'div',
            'class' => 'floatleft',
        ],
        'emptyText' => '<b>Список категорий пуст</b>.',
        'summary' => ''
    ]);
    ?>
    <div class="clearfix"></div>

</div>
