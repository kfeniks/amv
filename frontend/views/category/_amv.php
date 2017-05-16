<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
$text = mb_substr($model->videos->comments, 0, 100).'...';
$name = mb_substr($model->videos->title, 0, 56);
?>

<h3 class="main-box-title cat-4"><a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->videos->id])?>"
                                    title="<?= Html::encode($model->videos->title) ?>"><?= Html::encode($name) ?></a></h3>
<div class="main-box-inside ">

    <article class="vce-post vce-lay-c post-192 post type-post status-publish format-video has-post-thumbnail hentry category-fashion post_format-post-format-video">

        <div class="meta-image">
            <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->videos->id])?>" title="<?= Html::encode($model->videos->title) ?>">
                <img width="375" height="195" src="/frontend/web/files/<?= Html::encode($model->videos->img) ?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="" />							<span class="vce-format-icon">
                    </span>
            </a>
        </div>

        <header class="entry-header">
            <span class="meta-category"><?= Html::encode($model->videos->user->username) ?></span>
            <h2 class="entry-title"></h2>
            <div class="entry-meta"><div class="meta-item date"><span class="updated">
                                    <?=  HtmlPurifier::process(Yii::$app->formatter->asDate($model->videos->created_at, 'd MMMM yyyy')) ?></span></div></div>	</header>

    </article>
</div>