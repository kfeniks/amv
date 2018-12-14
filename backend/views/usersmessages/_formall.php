<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\tinymce\TinyMce;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'message')->widget(TinyMce::className(),
        [
            'language' => 'ru',
            'options' => ['rows' => 20],
            'clientOptions' => [
                'plugins' => [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table contextmenu directionality",
                    "emoticons template paste textcolor colorpicker textpattern imagetools codesample toc",
                ],
                'toolbar1' => "undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
                'toolbar2' => "print preview media | forecolor backcolor emoticons | codesample",
                'image_advtab' => "true",
                'menubar' => "false",
                'theme' => "modern",
                'toolbar_items_size' => "small",
                'relative_urls' => "false",
                'remove_script_host' => "false",
                'external_filemanager_path' => '/backend/web/filemanager/',
                'filemanager_title' => 'Responsive Filemanager',
                'external_plugins' => [
                    // Кнопка загрузки файла в диалоге вставки изображения.
                    'filemanager' => '/backend/web/filemanager/plugin.min.js',
                    // Кнопка загрузки файла в тулбаре.
                    'responsivefilemanager' => '/backend/web/tinymce/plugins/responsivefilemanager/plugin.min.js',
                ],
            ]
        ]);

    ?>

    <?= $form->field($model, 'status')->checkbox(['checked' => 1]) ?>
    <?php
    echo DatePicker::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'date_time',
        'type' => DatePicker::TYPE_INPUT,

        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Create', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
