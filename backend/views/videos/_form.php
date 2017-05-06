<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use \kartik\time\TimePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
    <?= $form->field($model, 'author_id')->dropDownList(ArrayHelper::map(\frontend\models\User::find()->all(), 'id', 'username')); ?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'availability')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'anime')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'song')->textInput(['maxlength' => true]) ?>
    <?= Html::checkboxList('category', $selectedCategory, $category, ['multiple' => true]) ?>
    <?= $form->field($model, 'youtube')->textInput(['maxlength' => true]) ?>
    <?php
    echo DatePicker::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'premiered',
        'type' => DatePicker::TYPE_INPUT,

        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <?=$form->field($model, 'duration')->widget(TimePicker::classname(), [
        'pluginOptions' => [
            'autoclose'=>true,
            'showSeconds' => true,
            'showMeridian' => false,
            'minuteStep' => 1,
            'secondStep' => 5,
            'defaultTime' => '0:00:00',

        ]]);?>
    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'hits')->textInput() ?>
    <?php if ($model->img !== null){?>
    <img src="/frontend/web/files/<?= Html::encode($model->img) ?>" style="width: 500px; height: 333px;" alt="<?= Html::encode($this->title) ?>" />
    <?php } ?>
    <?= $form->field($model, 'fileImage')->fileInput(); ?>
    <?= $form->field($model, 'award_week')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'award_month')->checkbox(['checked' => 1]) ?>
    <?= $form->field($model, 'opinion_id')->dropDownList(ArrayHelper::map(\frontend\models\Opinion::find()->all(), 'id', 'opinion_name')); ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
