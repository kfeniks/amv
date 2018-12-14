<?php
namespace backend\controllers;

use backend\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\IpSearch;
use backend\models\Ip;


/**
 * Site controller
 */
class IpController extends Controller
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
        $searchModel = new IpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = User::find()->where(['id' => $model->user_id])->one();
        if($user == null){throw new NotFoundHttpException('Не удалось найти пользователя.');}
        if ($user->load(Yii::$app->request->post())) {
            if(!$user->save()){
                throw new NotFoundHttpException('Не удалось забанить пользователя.');
            }
            else{
                throw new NotFoundHttpException('Удалось забанить пользователя.');
            }
           // print_r(Yii::$app->request->post());
           // return $this->redirect(['index']);
        }

        return $this->render('view', [
            'model' => $model,
            'user' => $user,
        ]);

    }
    protected function findModel($id)
    {
        if (($model = Ip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    public function actionDelete($id)
    {
        if(!$this->findModel($id)){
            throw new NotFoundHttpException('Не удалось забанить пользователя.');
        }
        return $this->redirect(['index']);
    }

}