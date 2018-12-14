<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\models\Sex;
use frontend\models\Country;



/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?=
     $form->field($model, 'sex_id')->dropDownList(
         ArrayHelper::map(Sex::find()->all(), 'id', 'name')
    );
    ?>
            <?php
       //     'value' => Yii::$app->formatter->asDate($model->birthdate_day, 'dd-MM-yyyy'),
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
    <?=
    $form->field($model, 'country_id')->dropDownList(
        ArrayHelper::map(Country::find()->all(), 'id', 'name')
    );
    ?>
    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'website')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'about')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton('Обновить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
