<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use yii\helpers\Url;
use yii\helpers\HtmlPurifier;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<?php $this->beginBody() ?>

<div class="wrapper">

    <header class="main-header">
        <!-- Logo -->
        <a href="<?= Url::to(['site/index']) ?>" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>AMV</b>.pp.ua</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <? if (!Yii::$app->user->isGuest) { ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/backend/web/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">Admin</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="/backend/web/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <? $dateUser = \frontend\models\User::findOne(1) ?>
                                <p>
                                    Admin
                                    <small>Зарегистрирован с <?= HtmlPurifier::process(Yii::$app->formatter->asDate($dateUser->created_at, 'd MMMM yyyy'))  ?></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => 1])?>" class="btn btn-default btn-flat">Profile</a>
                                </div>
                                <div class="pull-right">
                                    <?php
                                    echo Html::beginForm(['/site/logout'], 'post')
                                        . Html::submitButton(
                                            'Выйти',
                                            ['class' => 'btn btn-default btn-flat']
                                        )
                                        . Html::endForm();
                                   ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <? } ?>
                    <!-- Control Sidebar Toggle Button -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->

            <!-- search form -->

            <!-- /.search form -->
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li class="header">MAIN NAVIGATION</li>
                <li class="<?php if ( Url::current() == "/admin/login" || Url::current() == "/admin/") { ?>active<?php } ?> treeview">
                    <a href="#">
                        <i class="fa fa-dashboard"></i> <span>Основное меню</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                       <? if (Yii::$app->user->isGuest) { ?>
                           <li <?php if ( Url::current() == "/admin/login") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['site/login']); ?>"><i class="fa fa-circle-o"></i> Login</a></li>
                        <? } else {?>
                        <li <?php if ( Url::current() == "/admin/") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['site/index']); ?>"><i class="fa fa-circle-o"></i> Главная</a></li>
                           <?php } ?>
                    </ul>
                </li>
                <? if (!Yii::$app->user->isGuest) { ?>
                <li class="<?php if ( Url::current() == "/admin/user/index" ||
                    Url::current() == "/admin/user/create"
                ) { ?>active<?php } ?> treeview">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Пользователи</span>
                        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                    </a>
                    <ul class="treeview-menu">
                        <li <?php if ( Url::current() == "/admin/user/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['user/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                        <li <?php if ( Url::current() == "/admin/user/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['user/create']); ?>"><i class="fa fa-circle-o"></i> Создать</a></li>
                    </ul>
                </li>

                    <li class="<?php if ( Url::current() == "/admin/ip/index"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-user-plus"></i>
                            <span>Учет посещений с ip</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/ip/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['ip/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ( Url::current() == "/admin/news/index" ||
                        Url::current() == "/admin/news/create"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-file-word-o"></i>
                            <span>Новости (общие)</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/news/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['news/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                            <li <?php if ( Url::current() == "/admin/news/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['news/create']); ?>"><i class="fa fa-circle-o"></i> Создать</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ( Url::current() == "/admin/usernews/index" ||
                        Url::current() == "/admin/usernews/create"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-exclamation-triangle"></i>
                            <span>Уведомления авториз.</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/usernews/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['usernews/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                            <li <?php if ( Url::current() == "/admin/usernews/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['usernews/create']); ?>"><i class="fa fa-circle-o"></i> Создать</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ( Url::current() == "/admin/videos/index" ||
                        Url::current() == "/admin/videos/create" ||
                    Url::current() == "/admin/videos/create_videos" ||
                    Url::current() == "/admin/videos/create_local" ||
                    Url::current() == "/admin/videos/create_preview" ||
                    Url::current() == "/admin/videos/create_direct"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-video-camera"></i>
                            <span>Клипы</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/videos/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                            <li <?php if ( Url::current() == "/admin/videos/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/create']); ?>">
                                    <i class="fa fa-circle-o"></i> Создать (список)</a></li>
                            <li <?php if ( Url::current() == "/admin/videos/create_videos") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/create_videos']); ?>">
                                    <i class="fa fa-circle-o"></i> Создать описание</a></li>
                            <li <?php if ( Url::current() == "/admin/videos/create_local") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/create_local']); ?>">
                                    <i class="fa fa-circle-o"></i> Создать local</a></li>
                            <li <?php if ( Url::current() == "/admin/videos/create_preview") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/create_preview']); ?>">
                                    <i class="fa fa-circle-o"></i> Создать preview</a></li>
                            <li <?php if ( Url::current() == "/admin/videos/create_direct") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['videos/create_direct']); ?>">
                                    <i class="fa fa-circle-o"></i> Создать direct</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ( Url::current() == "/admin/faqs/index" ||
                        Url::current() == "/admin/faqs/create"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-question-circle"></i>
                            <span>Вопросы</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/faqs/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['faqs/index']); ?>"><i class="fa fa-circle-o"></i> Список</a></li>
                            <li <?php if ( Url::current() == "/admin/faqs/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['faqs/create']); ?>"><i class="fa fa-circle-o"></i> Создать</a></li>
                        </ul>
                    </li>

                    <li class="<?php if ( Url::current() == "/admin/usersmessages/index" ||
                        Url::current() == "/admin/usersmessages/create" ||
                        Url::current() == "/admin/usersmessages/all"
                    ) { ?>active<?php } ?> treeview">
                        <a href="#">
                            <i class="fa fa-envelope"></i>
                            <span>Личные сообщения</span>
                            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li <?php if ( Url::current() == "/admin/usersmessages/index") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['usersmessages/index']); ?>">
                                    <i class="fa fa-circle-o"></i> Список</a></li>
                            <li <?php if ( Url::current() == "/admin/usersmessages/create") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['usersmessages/create']); ?>">
                                    <i class="fa fa-circle-o"></i> Написать одному</a></li>
                            <li <?php if ( Url::current() == "/admin/usersmessages/all") { ?> class="active"<?php } ?> ><a href="<?= Url::to(['usersmessages/all']); ?>">
                                    <i class="fa fa-circle-o"></i> Написать всем</a></li>
                        </ul>
                    </li>
              <? } ?>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Панель управления
                <small>сайтом</small>
            </h1>
            <ol class="breadcrumb">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <?= Alert::widget() ?>
            <?= $content ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 2.4.0
        </div>
        <strong>&copy; amv.pp.ua <?= date('Y') ?>.</strong> All rights
        reserved.
    </footer>

    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3.1.1 -->
<script src="/backend/web/plugins/jQuery/jquery-3.2.1.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="/backend/web/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/backend/web/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/backend/web/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/backend/web/dist/js/demo.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
