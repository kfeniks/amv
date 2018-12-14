<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Local */

$check_url = Yii::$app->request->referrer;
//Проверяем является ли сайт подлинным (http://amv...) или ссылку вставили в другой сайт
$check_url_link = $check_url{7}.$check_url{8}.$check_url{9};
if($check_url_link != 'amv'){
    header('Location: '.Yii::$app->homeUrl);
    exit;
}

$model->preview_url = str_replace(array('"', "'", ' ', ','), '_', $model->preview_url);

    if (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($model->preview_url));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    // читаем файл и отправляем его пользователю
//    if(Yii::$app->session->get('idPreview') == null){readfile($model->filecloud);}
    if(Yii::$app->session->get('idPreview') == 1){readfile($model->yadicloud);}
    elseif(Yii::$app->session->get('idPreview') == 2){readfile($model->vkcloud);}
    elseif(Yii::$app->session->get('idPreview') == 3){readfile($model->dropboxcloud);}
    else{readfile($model->filecloud);}
    Yii::$app->session->remove('idPreview');
    exit;











