<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$text = mb_substr($model->videos->comments, 0, 100).'...';
?>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 tm-table-col">

    <table class="tm-table-full-width">
        <thead>
        <tr class="tm-bg-green-1">
            <th class="tm-plan-table-header"><?= Html::encode($model->videos->title) ?></th>
        </tr>
        </thead>
        <tbody>
        <tr class="tm-bg-green-2"><td class="tm-plan-table-cell"><img class="thumbnail" data-src="holder.js/300x200"
                                                                      alt="<?= Html::encode($model->videos->title) ?>" src="/frontend/web/files/<?= Html::encode($model->videos->img) ?>" style="width: 300px; height: 200px;"></td></tr>

        <tr class="tm-bg-green-1"><td class="tm-plan-table-cell"><?= HtmlPurifier::process($text) ?></td></tr>
        <tr class="tm-bg-green-3">
            <td class="tm-plan-table-cell tm-plan-table-cell-pad-small text-xs-center">
                <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->videos->id])?>" class="tm-bg-green-1 tm-btn-rounded tm-btn-green">Смотреть</a>
            </td>
        </tr>
        </tbody>
    </table>

</div>
