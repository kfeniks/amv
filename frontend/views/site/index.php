<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\widgets\ListView;
/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
<!-- 3. About -->
<div class="row" id="tm-section-1">

    <div class="container">
        <section class="tm-2-col-img-text">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 tm-2-col-img">
                <i class="fa fa-5x fa-video-camera"></i>
                <i class="fa fa-5x fa-hand-peace-o"></i>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 tm-2-col-text white">
                <h2 class="tm-2-col-text-title">Добро пожаловать на AMV.PP.UA</h2>
                <p class="tm-2-col-text-description">
                    Этот сайт посвящен созданию, обсуждению и общему удовольствию от сделанных поклонниками аниме клипов AMV (anime music video).
                </p>
            </div>

        </section>

        <section class="tm-2-col-img-text" id="tm-section-2">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 tm-2-col-text white">
                <h2 class="tm-2-col-text-title">Почему стоит зарегистрироваться?</h2>
                <p class="tm-2-col-text-description">
                    На сайте периодически выкладываются тщательно отобранные из общего потока АМВ клипы.
                    Публикуются новости о соревнованиях и событиях так или иначе связанных с АМВ.
                    Все добавленные клипы помещаются в архив со ссылками для закачки, рейтингом и подробной информацией.
                    Мы надеемся, что этим самым мы познакомим вас с миром Anime Music Videos и пополним вашу коллекцию самым качественным контентом.
                </p>
            </div>

        </section>
    </div>

</div> <!-- About section, tm-section-1 & 2 -->

</div> <!-- container-fluid -->
</div> <!-- tm-bg-img-header -->

<div class="container-fluid">

    <!-- Plan -->
    <div class="row tm-section" id="tm-section-3">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center">
            <h2 class="tm-section-title">Лучшие амв клипы месяца</h2>
            <p class="tm-section-subtitle">
                Лучший способ научиться делать отличные аниме клипы - это понять, как сделали шедевр другие.
                Поэтому предлагаем вам насладиться просмотром лучших amv работ по мнению наших критиков.
            </p>
        </div>

        <div id="primary" class="vce-main-content">

            <div class="vce-module-columns">
                <?php if($model){
                foreach ($model as $video){
                    $text = mb_substr($video->comments, 0, 100).'...';
                    $name = mb_substr($video->title, 0, 56);
                    ?>

                <div class="main-box vce-border-top main-box-half">

                    <h3 class="main-box-title cat-4"><a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $video->id])?>"
                                                        title="<?= Html::encode($video->title) ?>"><?= Html::encode($name) ?></a></h3>
                    <div class="main-box-inside ">

                        <article class="vce-post vce-lay-c post-192 post type-post status-publish format-video has-post-thumbnail hentry category-fashion post_format-post-format-video">

                            <div class="meta-image">
                                <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $video->id])?>" title="Hipster Yoga at the End of the World">
                                    <img width="375" height="195" src="/frontend/web/files/<?= Html::encode($video->img) ?>" class="attachment-vce-lay-b size-vce-lay-b wp-post-image" alt="" />							<span class="vce-format-icon">
                    </span>
                                </a>
                            </div>

                            <header class="entry-header">
                                <span class="meta-category"><?= Html::encode($video->user->username) ?></span>
                                <h2 class="entry-title"></h2>
                                <div class="entry-meta"><div class="meta-item date"><span class="updated">
                                    <?=  HtmlPurifier::process(Yii::$app->formatter->asDate($video->created_at, 'd MMMM yyyy')) ?></span></div></div>	</header>

                            <div class="entry-content">
                                <p><?= HtmlPurifier::process($text) ?></p>
                            </div>

                        </article>
                    </div>

                </div>
                <?php }} ?>

            </div> <!-- tm-plan-boxes-container -->

        </div> <!-- .col-xs-12 -->

    </div> <!-- row -->

</div> <!-- container-fluid -->

<div class="tm-bg-img-content">
    <div class="container-fluid">
        <div class="row" id="tm-section-4">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center">

                <h2 class="tm-section-title">Карта сайта</h2>
                <p class="tm-section-subtitle tm-section-subtitle-contact">
                    <?php
                    if (Yii::$app->user->isGuest) { ?>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["news/index"])?>" >Новости &raquo;</a></p>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/index"])?>" >Видео &raquo;</a></p>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["site/signup"])?>" >Регистрация &raquo;</a></p>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["site/login"])?>" >Войти &raquo;</a></p>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["user/index"])?>" >Пользователи &raquo;</a></p>
                <p><a href="<?=Yii::$app->urlManager->createUrl(["site/about"])?>" >О нас &raquo;</a></p>

                <?php } else {?>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["news/index"])?>" >Новости &raquo;</a></p>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["videos/index"])?>" >Видео &raquo;</a></p>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["site/contact"])?>" >Напиши нам &raquo;</a></p>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["site/home"])?>" >Главная профиля &raquo;</a></p>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["user/index"])?>" >Пользователи &raquo;</a></p>
                    <p><a href="<?=Yii::$app->urlManager->createUrl(["site/about"])?>" >О нас &raquo;</a></p>
                <?php } ?>
                </p>

            </div>
        </div>
    </div>
</div> <!-- contact section header -->

<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">

        <div class="container white">

            <h2 class="tm-section-title">Что такое AMV?</h2>
            <p class="tm-section-subtitle tm-section-subtitle-contact">
                AMV (сокр. от англ.Anime Music Video) – любительский музыкальный видеоклип, созданный с использованием фрагментов из аниме,
                манги или японских видеоигр и любой музыкальной композиции. Допускаются также другие исходные материалы, например,
                собственная анимация, арты или «живое» видео, но они не должны быть основными. Клипы, сделанные полностью не на аниме
                (например, мультфильмы студии Дисней), или на неяпонские видеоигры (например, StarCraft), а также на «живое» видео (кинофильмы),
                AMV не являются. Профессионально сделанные клипы на аниме (например, Wamdue Project - King of My Castle) и
                клипы на оригинальную анимацию в стиле аниме (например, On Your Mark) также не считаются AMV.
                Клипы на кадры из видеоигр выделяют в подвид game music videos, или GMV.
            </p><br>

            <p class="tm-section-subtitle tm-section-subtitle-contact">
                amv gmv аниме клипы музыка видео скачать акросс япония игры видеоигры rpg рпг
                final fantasy evangelion видеомонтаж premiere after effects ae кодирование кодек кино фильм арт
                AMV, online, HD, аниме, клипы, музыка, видео, АМВ, кино, Naruto, Evangelion, Bleach, Наруто,
                Евангелион, видеоклипы, манга, конкурсы, скачать, бесплатно, смотреть, торрент, download, torrent, онлайн
            </p>

        </div>

