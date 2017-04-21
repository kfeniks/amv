<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Local */
$model->filedir;
$model->fileexists;
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false); // нужен для некоторых браузеров
header("Content-Disposition: attachment; filename=\"".basename($model->filedir)."\";" );
header("Content-Transfer-Encoding: binary");
readfile($model->filedir);
exit();








