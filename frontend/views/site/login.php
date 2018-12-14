<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Войти в свой профиль';
?>
<div class="container white">
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните все поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('Имя'); ?>

                <?= $form->field($model, 'password')->passwordInput()->label('Пароль'); ?>

                <?= $form->field($model, 'rememberMe')->checkbox()->label('Запомнить меня'); ?>

                <div style="color:#999;margin:1em 0">
                    Если ты забыл пароль <?= Html::a('восстановить пароль', ['site/request-password-reset']) ?>.
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
</div>

<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">
