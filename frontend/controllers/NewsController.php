<?php
namespace frontend\controllers;

use Yii;
use frontend\models\News;
use yii\data\ActiveDataProvider;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class NewsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => News::find()->where(['hide'=>News::STATUS_APPROVED])->orderBy('date DESC'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $this->view->title = 'Новости';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Музыкальные аниме клипы.'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'AMV, online, HD, аниме, клипы, музыка, видео, АМВ, кино, Naruto, Evangelion, Bleach, Наруто, Евангелион, видеоклипы, манга, конкурсы, скачать, бесплатно, смотреть, торрент, download, torrent, онлайн'
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = News::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }
}
