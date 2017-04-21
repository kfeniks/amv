<?php
namespace frontend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\Videos;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class UserController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['my_profile', 'update'],
                'rules' => [
                    [
                        'actions' => ['my_profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['status'=>User::STATUS_ACTIVE])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Пользователи';
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }


    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Videos::find()->where(['author_id'=>$this->findModel($id)->id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'listDataProvider' => $dataProvider
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }
}
