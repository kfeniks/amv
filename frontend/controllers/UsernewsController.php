<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Usernews;
use yii\data\ActiveDataProvider;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class UsernewsController extends \yii\web\Controller
{
    public function actionIndex()
    {

        return $this->redirect(['site/home']);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Usernews::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }
}
