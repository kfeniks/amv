<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'user_id')->dropDownList(ArrayHelper::map(\frontend\models\User::find()->all(), 'id', 'username')); ?>
    <?= $form->field($model, 'videos_id')->dropDownList(ArrayHelper::map(\frontend\models\Videos::find()->all(), 'id', 'title')); ?>
    <?= $form->field($model, 'check_availab')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'check_id')->dropDownList(ArrayHelper::map(\frontend\models\CheckVid::find()->all(), 'id', 'check_name')); ?>

    <?= $form->field($model, 'format_id')->radioList(\frontend\models\Format::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'codec_audio_id')->radioList(\frontend\models\CodecAudio::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'codec_vid_id')->radioList(\frontend\models\CodecVid::listAll(), ['multiple' => false]) ?>
    <?= $form->field($model, 'load_count')->textInput() ?>
    <?= $form->field($model, 'file_size')->textInput() ?>
    <p>Пример: 45.01</p>
    <?= $form->field($model, 'preview_url')->textInput() ?>
    <p>Внимание: виртуальный путь к файлу /kevinfeniks/Kevin_Feniks-Last_prev.avi</p>
    <?php if($model->url !== null){
        echo $model->FileExistsCloud;
    } ?>
    <?= $form->field($model, 'url')->textInput() ?>
    <p>Внимание: короткая ссылка на облако https://rocld.com/ссылка</p>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
