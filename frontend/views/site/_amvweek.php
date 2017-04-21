<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use frontend\models\User;

$model_user = User::find()->where(['id' => $model->author_id])->one();
?>

                                <div class="panel-body">
                                    <a href="<?=Yii::$app->urlManager->createUrl(["user/view", "id" => $model->author_id])?>">
                                        <?php if($model_user){ echo HtmlPurifier::process ($model_user->username); } ?></a> -
                                    <a href="<?=Yii::$app->urlManager->createUrl(["videos/view", "id" => $model->id])?>">
                                        <?= Html::encode($model->title); ?></a>
                                </div>