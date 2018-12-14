<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Userdownloads;
use frontend\models\Rankusers;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class DownloadsController extends Controller
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
            'query' => Userdownloads::find()->where(['user_id'=>Yii::$app->user->identity->getId()])->orderBy('create_date DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        $this->view->title = 'Скачанные мною клипы';
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionRank($id, $videos_id)
    {
        if($id !== null && $videos_id !== null){
         $rank = Rankusers::find()->where(['user_id'=>Yii::$app->user->identity->getId()])->andwhere(['videos_id' => $videos_id])->one();
         $downloads  = Userdownloads::find()->where(['user_id'=>Yii::$app->user->identity->getId()])->andwhere(['videos_id' => $videos_id])->one();
         if($rank == Null && $downloads !== Null){
             $rank = new Rankusers();
             $rank->user_id = Yii::$app->user->identity->getId();
             $rank->videos_id = $videos_id;
             $rank->rank_id = $id;
             $rank->save();
             if($rank !== Null){
             $downloads->status = 1;
             $downloads->save();
                return $this->redirect(['downloads/index']);
             }
         }
         else {return $this->redirect(['site/error']);}

        }
        else {return $this->redirect(['site/error']);}
    }

    protected function findModel($id)
    {
        if (($model = Userdownloads::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }


}
