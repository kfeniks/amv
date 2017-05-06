<?php
namespace backend\controllers;

use backend\models\Videos;
use backend\models\Local;
use backend\models\Preview;
use backend\models\Direct;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\VideosSearch;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * Site controller
 */
class VideosController extends Controller
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
                    'deletepreview' => ['POST'],
                    'deletedirect' => ['POST'],
                    'deletevideos' => ['POST'],
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
        $searchModel = new VideosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => \frontend\models\Videos_category::find()->where(['videos_id' => $id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'listDataProvider' => $dataProvider
        ]);

    }

    protected function findModel($id)
    {
        if (($model = Videos::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        Yii::$app->session->set('idVideo', $model->id);

        return $this->render('update', [
            'model' => $model,

        ]);
    }

    public function actionCreate()
    {
        $model = new Videos();

        return $this->render('create', [
            'model' => $model,

        ]);
    }

    public function actionCreate_videos()
    {
        $model = new Videos();
        $selectedCategory = $model->getSelectedCategory();
        $category = ArrayHelper::map(\frontend\models\Category::find()->all(), 'id', 'cat_name');
        Yii::$app->session->set('idVideo', $model->id);
        if ($model->load(Yii::$app->request->post()) ) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if ($model->fileImage == Null) {
                return $this->redirect(['pic_error']);
            }
            $model->folder;
            $dirname = __DIR__.'/../../frontend/web/files/';
            $model->img = $model->user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension;
            $category = Yii::$app->request->post('category');
            if(!$model->save()){
              return $this->redirect(['site/error']);
                }
            $model->saveCategory($category);
            $model->fileImage->saveAs($dirname . $model->user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);

            return $this->redirect(['create']);
        }

        else
        {
            return $this->render('create_videos', [
                'model' => $model,
                'selectedCategory' => $selectedCategory,
                'category' => $category
            ]);
        }

    }

    public function actionCreate_local()
    {
        $model = new Local();

        if ( $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        } else {
            return $this->render('create_local', [
                'model' => $model,
            ]);
        }
    }
    public function actionCreate_preview()
    {
        $model = new Preview();

        if ( $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        } else {
            return $this->render('create_preview', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate_direct()
    {
        $model = new Direct();

        if ( $model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create']);
        } else {
            return $this->render('create_direct', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate_videos_step1($id)
    {
        $model = $this->findModel($id);
        $selectedCategory = $model->getSelectedCategory();
        $category = ArrayHelper::map(\frontend\models\Category::find()->all(), 'id', 'cat_name');
        $model->updated_at = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if($model->fileImage){
                $current_image = $model->img;
                $dirname = __DIR__.'/../../frontend/web/files/';
                $dir = $dirname.$current_image;
                if(file_exists($dir))
                {
                    //удаляем файл
                    unlink($dir);
                    $model->img = '';
                }
                $model->folder;
                $model->img = $model->user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension;
                if(!$model->save()){return $this->redirect(['site/error']);}
                $model->fileImage->saveAs($dirname . $model->user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);
                return $this->redirect(['update', 'id' => $model->id]);
            }
            else {
                $category = Yii::$app->request->post('category');
                if($model->save()){ $model->saveCategory($category);}
                else{return $this->redirect(['site/error']);}
                return $this->redirect(['update', 'id' => $model->id]);
            }

        } else {
            return $this->render('update_videos_step1', [
                'model' => $model,
                'selectedCategory' => $selectedCategory,
                'category' => $category,
            ]);
        }

    }

    public function actionUpdate_videos_step2($id)
    {
        $model = $this->findOnelocal($id);
        $model->updated_at = date("Y-m-d H:i:s");
        $model->check_date = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

                return $this->redirect(['update', 'id' => $model->videos_id]);}


         else {
            return $this->render('update_videos_step2', [
                'model' => $model,
            ]);
        }

    }
    public function actionUpdate_videos_step3($id)
    {
        $model = $this->findOnepreview($id);
        $model->updated_at = date("Y-m-d H:i:s");
        $model->check_date = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //    print_r(Yii::$app->request->post());
           return $this->redirect(['update', 'id' => $model->videos_id]);
            }

        else {
            return $this->render('update_videos_step3', [
                'model' => $model,
            ]);
        }

    }
    public function actionUpdate_videos_step4($id)
    {
        $model = $this->findOnepreview($id);
        $model->updated_at = date("Y-m-d H:i:s");
        $model->check_date = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->videos_id]);
        }

        else {
            return $this->render('update_videos_step4', [
                'model' => $model,
            ]);
        }

    }

    public function actionDeletepreview($id)
    {
        $model = $this->findOnepreview($id);
        $dirname = __DIR__.'/../web/files';
        $dir = $dirname.$model->preview_url;
        if (file_exists($dir)) {
            unlink($dir);
        }
        $this->findOnepreview($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeletedirect($id)
    {
        $this->findOnedirect($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
    public function actionDeletevideos($id)
    {
        $preview = \frontend\models\Preview::find()->where(['videos_id' => $id])->one();
        $direct = \frontend\models\Direct::find()->where(['videos_id' => $id])->one();
        $local = \frontend\models\Local::find()->where(['videos_id' => $id])->one();
        $videosCategory = \frontend\models\Videos_category::find()->where(['videos_id' => $id])->all();
        $userDownloads = \frontend\models\Userdownloads::find()->where(['videos_id' => $id])->all();
        $rankUsers = \frontend\models\Rankusers::find()->where(['videos_id' => $id])->all();
        if(!$preview == null){$preview->delete();}
        if(!$direct == null){$direct->delete();}
        if(!$local == null){$local->delete();}
        if(!$videosCategory == null){\frontend\models\Videos_category::deleteAll(['videos_id' => $id]);}
        if(!$userDownloads == null){\frontend\models\Userdownloads::deleteAll(['videos_id' => $id]);}
        if(!$rankUsers == null){\frontend\models\Rankusers::deleteAll(['videos_id' => $id]);}

        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }
    protected function findOnepreview($id)
    {
        return Preview::findOne($id);
    }
    protected function findOnedirect($id)
    {
        return \frontend\models\Direct::findOne($id);
    }
    protected function findOnelocal($id)
    {
        return Local::findOne($id);
    }

}