<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
?>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-table-col borderblack">

            <p class="tm-plan-table-header"><?= Html::encode($model->user->username) ?></p>
            <p class="tm-plan-table-header"><?= Html::encode($model->host) ?></p>
            <p class="tm-plan-table-header"><?= Html::encode($model->ip) ?></p>
            <p class="tm-plan-table-header"><?=  HtmlPurifier::process(Yii::$app->formatter->asDate($model->date, 'd MMMM yyyy')) ?></p>



</div>