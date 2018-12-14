<?php
use yii\helpers\Html;

?>
<?php if($model->catCount > 0){ ?>
<p class="lead"><a href="<?=Yii::$app->urlManager->createUrl(["category/view", "id" => $model->vidcategory->category_id])?>" ><b><?= Html::encode($model->cat_name) ?></b></a> (<?= Html::encode($model->catCount) ?>)</p>
<?php } else echo ''; ?>
