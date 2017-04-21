<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;





/* @var $this yii\web\View */
/* @var $model frontend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'anime')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'song')->textInput(['maxlength' => true]) ?>
    <?php
    echo Html::checkboxList('category', $selectedCategory, $category, ['multiple' => true])

    //     $form->field($model, 'category')->checkboxList('category', $selectedCategory, $category, ['multiple' => true])
    //    echo $form->field($model, 'category')->listBox(
    //        ArrayHelper::map($category, 'id', 'cat_name'),
    //        [
    //            'multiple' => true
    //        ]
    //    )

    ?>
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
    <?= $form->field($model, 'comments')->textarea(['rows' => 6]) ?>
    <img src="/frontend/web/files/<?= Html::encode($model->img) ?>" alt="<?= Html::encode($this->title) ?>" />
    <?= $form->field($model, 'fileImage')->fileInput(); ?>
    <p>Клип </p>
    <?= $form->field($model, 'status')->checkbox(['checked' => 1]) ?>


    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
