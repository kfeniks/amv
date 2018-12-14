<?php
use yii\widgets\LinkPager;
?>
<div class="container white">
<h2>Результаты поиска: </h2>
<?php if (!$videos) { ?>
    <p>Ничего не найдено</p>
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
