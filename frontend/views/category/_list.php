<?php
use yii\helpers\Html;

?>

<p class="lead"><a href="<?=Yii::$app->urlManager->createUrl(["category/view", "id" => $model->category_id])?>" ><b><?= Html::encode($model->catName) ?></b></a> (<?= Html::encode($model->catCount) ?>)</p>

