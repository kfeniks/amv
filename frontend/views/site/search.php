<?php
use yii\widgets\LinkPager;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div class="container white">
<h2>Результаты поиска: </h2>
<?php if (!$videos) { ?>
    <p>Ничего не найдено</p>
<?php $form = ActiveForm::begin([
    'action' => ['search'],
        'method' => 'post',
    ])?>
    <?= $form->field($q, 'q') ?>
    <?= Html::submitButton('Search', ['class' => 'btn btn-primary'])?>
    <?= Html::resetButton('Search', ['class' => 'btn btn-default'])?>
    <?php ActiveForm::end(); ?>
<?php } else { ?>
<?php foreach ($videos as $video) include "_video.php"; ?>
<br />
<hr />
<div id="pages">
    <?= LinkPager::widget([
        'pagination' => $pages,
        'firstPageLabel' => 'В начало',
        'lastPageLabel' => 'В конец',
        'prevPageLabel' => '&laquo;'
    ]) ?>
    <div class="clear"></div>
</div>
<?php }?>
</div>
