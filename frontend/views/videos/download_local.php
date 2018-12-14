<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\Local */

// $model->fileexistscloud;
// Yii::$app->response->redirect($model->filecloud, 301)->send();

$check_url = Yii::$app->request->referrer;
//Проверяем является ли сайт подлинным (http://amv...) или ссылку вставили в другой сайт
$check_url_link = $check_url{7}.$check_url{8}.$check_url{9};
if($check_url_link != 'amv'){
    header('Location: '.Yii::$app->homeUrl);
    exit;
}

$url = $model->filecloud;
$headers = get_headers($url, 1);
$model->local_url = str_replace(array('"', "'", ' ', ','), '_', $model->local_url);
if(in_array('video/x-msvideo', $headers) or in_array('video/mp4', $headers) or in_array('video/mpeg', $headers) or in_array('video/x-ms-wmv', $headers)){

    if (ob_get_level()) {
        ob_end_clean();
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($model->local_url));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    // читаем файл и отправляем его пользователю
//    if(Yii::$app->session->get('idLocal') == null){readfile($model->filecloud);}
    if(Yii::$app->session->get('idLocal') == 1){readfile($model->yadicloud);}
    elseif(Yii::$app->session->get('idLocal') == 2){readfile($model->vkcloud);}
    elseif(Yii::$app->session->get('idLocal') == 3){readfile($model->dropboxcloud);}
    else{readfile($model->filecloud);}
    Yii::$app->session->remove('idLocal');
    exit;

}
else{
    return $cloud = 'Файла нет.';
}
?>











