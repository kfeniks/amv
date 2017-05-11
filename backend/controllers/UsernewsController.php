<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\Usernews;
use backend\models\UsernewsSearch;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class UsernewsController extends Controller
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
        $searchModel = new UsernewsSearch();
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
        if (($model = Usernews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->date_update = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if($model->fileImage){
                $current_image = $model->img;
                $dirname = __DIR__.'/../../frontend/web/images/news/';
                $dir = $dirname.$current_image;
                if(file_exists($dir))
                {
                    //удаляем файл
                    unlink($dir);
                    $model->img = '';
                }
                $model->folder;
                $model->img = $model->fileImage->baseName . '.' . $model->fileImage->extension;
                if(!$model->save()){return $this->redirect(['site/error']);}
                $model->fileImage->saveAs($dirname . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);
                return $this->redirect(['update', 'id' => $model->id]);
            }
            else {
                if(!$model->save()){return $this->redirect(['site/error']);}
                return $this->redirect(['update', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,

        ]);
    }

    public function actionCreate()
    {
        $model = new Usernews();

        if ($model->load(Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if($model->fileImage){
                $dirname = __DIR__.'/../../frontend/web/images/news/';
                $model->folder;
                $model->img = $model->fileImage->baseName . '.' . $model->fileImage->extension;
                if(!$model->save()){return $this->redirect(['site/error']);}
                $model->fileImage->saveAs($dirname . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);
                return $this->redirect(['update', 'id' => $model->id]);
            }
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