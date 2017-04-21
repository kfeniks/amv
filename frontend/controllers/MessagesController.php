<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Messages;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class MessagesController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Messages::find()->where(['user_id_to'=>Yii::$app->user->identity->getId()])->orderBy('date_time DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Личные сообщения';
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
        if (($model = Messages::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }


}
