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
    <?php if ($model->avatar !== null){?>
        <img src="/frontend/web/images/users/<?= Html::encode($model->avatar) ?>" style="width: 100px; height: 100px;" alt="<?= Html::encode($model->username) ?>" />
    <?php } ?>
    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'profile_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sex_id')->dropDownList(ArrayHelper::map(\frontend\models\Sex::find()->all(), 'id', 'name')); ?>

    <?php
    echo DatePicker::widget([
        'model' => $model,
        'form' => $form,
        'attribute' => 'birthdate_day',
        'type' => DatePicker::TYPE_INPUT,

        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ]);
    ?>
    <?= $form->field($model, 'country_id')->dropDownList(ArrayHelper::map(\frontend\models\Country::find()->all(), 'id', 'name')); ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'about')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>
    <p>0 - забанен, 5 - без активации, 10 - активен</p>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'karma')->textInput() ?>

    <?= $form->field($model, 'fileImage')->fileInput(); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
