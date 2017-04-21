<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Faqs;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class FaqsController extends Controller
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
            'query' => Faqs::find()->where(['status'=>Faqs::STATUS_APPROVED])->orderBy('create_date DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Руководство пользователя';
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionSite()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Faqs::find()->where(['cat_id'=>Faqs::STATUS_SITE])->andwhere(['status'=>Faqs::STATUS_APPROVED])->orderBy('create_date DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Все вопросы про сайт';
        return $this->render('site', ['listDataProvider' => $dataProvider]);
    }

    public function actionProfile()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Faqs::find()->where(['cat_id'=>Faqs::STATUS_PROFILE])->andwhere(['status'=>Faqs::STATUS_APPROVED])->orderBy('create_date DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Вопросы о профиле';
        return $this->render('profile', ['listDataProvider' => $dataProvider]);
    }

    public function actionAmv()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Faqs::find()->where(['cat_id'=>Faqs::STATUS_AMV])->andwhere(['status'=>Faqs::STATUS_APPROVED])->orderBy('create_date DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Вопросы о клипах';
        return $this->render('amv', ['listDataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Faqs::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }


}
