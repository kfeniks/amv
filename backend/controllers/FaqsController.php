<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\Faqs;
use backend\models\FaqsSearch;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class FaqsController extends Controller
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
        $searchModel = new FaqsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id)
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Faqs::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if(!$model->save()){return $this->redirect(['site/error']);}
                return $this->redirect(['update', 'id' => $model->id]);

        }
        return $this->render('update', [
            'model' => $model,

        ]);
    }

    public function actionCreate()
    {
        $model = new Faqs();

        if ($model->load(Yii::$app->request->post())) {
                if(!$model->save()){return $this->redirect(['site/error']);}
                return $this->redirect(['update', 'id' => $model->id]);

        }
        else{

            return $this->render('create', [
                'model' => $model,

            ]);

        }

    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

}