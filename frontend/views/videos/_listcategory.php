<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>
<a class="btn btn-default" href="<?=Yii::$app->urlManager->createUrl(["category/view", "id" => $model->category_id])?>" role="button"><?= Html::encode($model->catName) ?></a>

