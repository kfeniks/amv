<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
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
    <?= $form->field($model, 'local_url')->textInput() ?>
    <p>Внимание: виртуальный путь к файлу /kevinfeniks/Kevin_Feniks-Last_HQ.avi</p>
    <?php if($model->url !== null){
        echo $model->FileExistsCloud;
     } ?>
    <?= $form->field($model, 'url')->textInput() ?>
    <p>Внимание: короткая ссылка m5gca на облако Mail.ru Диск через Rocld.com</p>

    <?php if($model->yadi !== null){
        echo $model->YadiExistsCloud;
    } ?>
    <?= $form->field($model, 'yadi')->textInput() ?>
    <p>Внимание: короткая ссылка G7cvo4l-3M5Bjw на облако Яндекс Диск через getfile.dokpub.com</p>

    <?php if($model->vk !== null){
        echo $model->VkExistsCloud;
    } ?>
    <?= $form->field($model, 'vk')->textInput() ?>
    <p>Внимание: короткая ссылка 5131697_449239941 на документы Vk.com</p>


    <?php if($model->dropbox !== null){
        echo $model->DropboxExistsCloud;
    } ?>
    <?= $form->field($model, 'dropbox')->textInput() ?>
    <p>Внимание: короткая ссылка c2w68pfwarxdlwa/0134.Wolf_Snow_-_Night-Patrol_full.keccgroup.ru.avi на облако Dropbox</p>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
