<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановить пароль';
?>
<div class="container white">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, напишите свой емеил. Ссылка на восстановление пароля будет отправлена вам на емеил.</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true])->label('Мой email адрес') ?>

                <div class="form-group">
                    <?= Html::submitButton('Восстановить', ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="tm-bg-img-footer tm-section-contact-form">
    <div class="container-fluid">