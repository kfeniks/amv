<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use dosamigos\tinymce\TinyMce;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if ($model->img !== null){?>
        <img src="/frontend/web/images/news/<?= Html::encode($model->img) ?>" style="width: 500px; height: 333px;" alt="<?= Html::encode($this->title) ?>" />
    <?php } ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'text')->widget(TinyMce::className(),
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

    <?= $form->field($model, 'hits')->textInput() ?>
    <?= $form->field($model, 'is_release')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'hide')->checkbox(['checked' => 1]) ?>
    <?php
    echo DatePicker::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'date_create',
        'type' => DatePicker::TYPE_INPUT,

        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <?= $form->field($model, 'fileImage')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
