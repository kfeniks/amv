<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\bootstrap\Nav;
$this->registerJsFile('/frontend/web/js/jquery-1.11.3.min.js',  ['position' => yii\web\View::POS_HEAD]);
$this->registerJsFile('/frontend/web/js/jquery.singlePageNav.min.js',  ['position' => yii\web\View::POS_HEAD]);

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">  <!-- Google web font "Open Sans" -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- jQuery (https://jquery.com/download/) -->
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="tm-bg-img-content">
<?php $this->beginBody() ?>


<div class="tm-bg-img-header">
    <div class="container-fluid">

        <div id="top" class="tm-header-container">

            <!-- 1. Site Header -->
            <div class="row tm-site-header">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center">

                    <h1 class="tm-site-title"><?=Yii::$app->name?></h1>
                    <p class="tm-site-description">Музыкальные аниме клипы</p>

                </div>
            </div>

            <!-- 2. Navigation -->
            <div class="row tm-navbar-row tm-navbar-row-absolute">
                <div class="tm-navbar-container">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <nav class="navbar navbar-full">

                            <div class="text-xs-center tm-navbar-rounded" id="tmNavbar">

                                <ul class="nav zavbar-nav tron">
                                    <?php
                                    if (Yii::$app->user->isGuest) { ?>
                                    <li class="nav-item ">
                                        <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/index"])?>">Главная</a>
                                    </li>
                                        <li class="nav-item ">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["news/index"])?>">Новости</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["videos/index"])?>">Клипы</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/about"])?>">О нас</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/signup"])?>">Регистрация</a>
                                        </li>
                                        <li class="nav-item ">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/login"])?>">Войти</a>
                                        </li>
                                    <?php } else {?>
                                        <li class="nav-item ">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/home"])?>">Главная</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["videos/index"])?>">Клипы</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["user/index"])?>">Пользователи</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external" href="<?=Yii::$app->urlManager->createUrl(["site/contact"])?>">Напиши нам</a>
                                        </li>
                                    <?php
                                                                       echo '<li class="nav-item">'
                                        . Html::beginForm(['/site/logout'], 'post')
                                        . Html::submitButton(
                                            'Выйти (' . Yii::$app->user->identity->username . ')',
                                            ['class' => 'tm-bg-blue-1 tm-btn-rounded tm-btn-rounded-tall tm-btn-blue external']
                                        )
                                        . Html::endForm()
                                        . '</li>';
                                                                    }
                                    ?>

                                </ul>

                            </div>

                        </nav>
                    </div> <!-- col-xs-12 -->
                </div> <!-- tm-navbar-container -->
            </div> <!-- row -->

        </div> <!-- .tm-header-container -->


<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<?= Alert::widget() ?>
<?= $content ?>

        <div class="row tm-footer">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center">

                <div class="tm-social-icons-container tron">
                    <a href="#" class="tm-social-icon-link-brown"><i class="fa fa-facebook tm-social-icon"></i></a>
                    <a href="#" class="tm-social-icon-link-brown"><i class="fa fa-google-plus tm-social-icon"></i></a>
                    <a href="#" class="tm-social-icon-link-brown"><i class="fa fa-twitter tm-social-icon"></i></a>
                    <a href="#" class="tm-social-icon-link-brown"><i class="fa fa-behance tm-social-icon"></i></a>
                    <a href="#" class="tm-social-icon-link-brown"><i class="fa fa-linkedin tm-social-icon"></i></a>
                </div>

            </div>

            <footer class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 text-xs-center trono">
                <p class="tm-copyright-text">&copy; AMV Anime Music Videos <?= date('Y') ?>. Сайт создан <a href="http://keccgroup.ru">студией вебразработки KECCGroup.ru</a></p>
            </footer>

        </div>
    </div>
</div> <!-- tm-section-contact-form -->







<script>

    function prepareMenuForDesktop() {

        var navbarHeight = 0;

        // For screens greater than 767
        if($(window).width() > 767) {

            // target at which the menu bar changes to sticky
            var target = $("#tm-section-1").offset().top - 100;

            // window scroll
            $(window).scroll(function(){

                if($(this).scrollTop() > target) {
                    $(".tm-navbar-row").addClass("sticky");
                }
                else {
                    $(".tm-navbar-row").removeClass("sticky");
                }

            });

            navbarHeight = 56;
        }

        // Single Page Nav
        $('#tmNavbar').singlePageNav({
            'currentClass' : "active",
            offset : navbarHeight,
            'filter': ':not(.external)'
        });
    }

    $(document).ready(function(){

        prepareMenuForDesktop();

        // On window resize, prepare menu
        $(window).resize(function(){
            prepareMenuForDesktop();

        });
    });

</script>

<?php $this->endBody() ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter44410777 = new Ya.Metrika({
                    id:44410777,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/44410777" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
</body>
</html>
<?php $this->endPage() ?>
