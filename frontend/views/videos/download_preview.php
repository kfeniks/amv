<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Local */
$url = $model->filecloud;
$headers = get_headers($url, 1);
if(in_array('video/x-msvideo', $headers)){

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
    readfile($model->filecloud);
    exit;

}
elseif (in_array('video/mp4', $headers)){

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
    readfile($model->filecloud);
    exit;

}
else{
    return $cloud = 'Файла нет.';
}









