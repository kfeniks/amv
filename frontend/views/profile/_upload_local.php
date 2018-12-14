<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\models\Format;
use frontend\models\CodecAudio;
use frontend\models\CodecVid;

/* @var $this yii\web\View */
/* @var $model frontend\models\Videos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>


    <?= $form->field($model, 'format_id')->radioList(Format::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'codec_audio_id')->radioList(CodecAudio::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'codec_vid_id')->radioList(CodecVid::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'check_availab')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'fileAmv')->fileInput(); ?>
    <p>Внимание: файл не должен быть более 100мб</p>



    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>

