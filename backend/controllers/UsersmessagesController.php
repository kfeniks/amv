<?php
namespace backend\controllers;

use backend\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\UsersmessagesSearch;
use backend\models\Usersmessages;


/**
 * Site controller
 */
class UsersmessagesController extends Controller
{
    /**
     * @inheritdoc
     */
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersmessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);

    }

    public function actionCreate()
    {
        $model = new Usersmessages();

        if ($model->load(Yii::$app->request->post())) {
            $model->user_id_from = Yii::$app->user->identity->id;
            if(!$model->save()){return $this->redirect(['site/error']);}
            return $this->redirect(['view', 'id' => $model->id]);

        }
        else{

            return $this->render('create', [
                'model' => $model,

            ]);

        }

    }

    public function actionAll()
    {
        $model = new Usersmessages();

        if ($model->load(Yii::$app->request->post())) {
            $users = User::find()->all();
            foreach ($users as $user) {
                $messages = new Usersmessages();
                $messages->user_id_from = Yii::$app->user->identity->id;
                $messages->user_id_to = $user->id;
                $messages->date_time = $model->date_time;
                $messages->status = $model->status;
                $messages->subject = $model->subject;
                $messages->message = $model->message;
                if(!$messages->save()){return $this->redirect(['site/error']);}
            }

            return $this->redirect(['index']);

        }
        else{

            return $this->render('all', [
                'model' => $model,

            ]);

        }

    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->save()){return $this->redirect(['site/error']);}
            return $this->redirect(['view', 'id' => $model->id]);

        }
        return $this->render('update', [
            'model' => $model,

        ]);
    }


    protected function findModel($id)
    {
        if (($model = Usersmessages::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDelete($id)
    {
        if(!$this->findModel($id)){
            throw new NotFoundHttpException('Не удалось удалить сообщение.');
        }
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}