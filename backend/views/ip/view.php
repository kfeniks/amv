<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Ip', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>
<?php if($user->status !== 0){?>
    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($user, 'status')->hiddenInput(['value' => '0'])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Ban', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php } ?>

    <?php $model->getIpcheck();?>
    <div class="clearfix"></div>

</div>
