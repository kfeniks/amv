<?php
namespace frontend\controllers;

use Yii;
use yii\filters\VerbFilter;
use frontend\models\PasswordChangeForm;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use common\models\User;
use frontend\models\Videos;
use frontend\models\VideosUpdate;
use frontend\models\Local;
use frontend\models\Preview;
use frontend\models\Direct;
use frontend\models\Category;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;
use frontend\models\Videos_category;





/**
 * PostsController implements the CRUD actions for Posts model.
 */
class ProfileController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'deletepreview' => ['POST'],
                    'deletedirect' => ['POST'],
                ],
            ],
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
        return $this->render('index', [
            'model' => $this->findModel(),
        ]);
    }
    public function actionPic_error(){
        return $this->render('pic_error');
    }

    public function actionPasswordChange()
    {
        $user = $this->findModel();
        $model = new PasswordChangeForm($user);

        if ($model->load(Yii::$app->request->post()) && $model->changePassword()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('passwordChange', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreate()
    {
        $videosCount = Videos::find()->where(['author_id' => Yii::$app->user->identity->id])->count();
        if($videosCount >=20){return $this->redirect(['profile/videos']);}
        $model = new Videos();
        $selectedCategory = $model->getSelectedCategory();
        $category = ArrayHelper::map(Category::find()->all(), 'id', 'cat_name');

        if ($model->load(Yii::$app->request->post()) ) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if ($model->fileImage == Null) {
                return $this->redirect(['pic_error']);
            }
            $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
            $model->folder;
            $model->img = $user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension;
            $model->author_id = Yii::$app->user->identity->id;
            $category = Yii::$app->request->post('category');
            $model->save();
            Yii::$app->session->set('idVideo', $model->id);
            $model->saveCategory($category);
            $model->fileImage->saveAs('files/' . $user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);

            return $this->redirect(['upload_local']);
        }

        else
        {

            //  print_r($model->getErrors());
            return $this->render('create', [
                'model' => $model,
                'selectedCategory' => $selectedCategory,
                'category' => $category
            ]);
        }

    }

    public function actionUpload_local()
    {
        $model = new Local();

        if ( $model->load(Yii::$app->request->post()) ) {
            $model->fileAmv = UploadedFile::getInstance($model, 'fileAmv');
            if ($model->fileAmv == Null) {
                return $this->redirect(['pic_error']);
            }
            $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
            $model->folder;
            $model->local_url = '/'. $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension;
            $model->user_id = Yii::$app->user->identity->id;
            $model->videos_id = Yii::$app->session->get('idVideo');
            $model->save();
            $model->fileAmv->saveAs('files/' . $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension);
            return $this->redirect(['upload_preview']);
        } else {
            return $this->render('upload_local', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpload_preview()
    {
        $model = new Preview();

        if ( $model->load(Yii::$app->request->post()) ) {
            $model->fileAmv = UploadedFile::getInstance($model, 'fileAmv');
            if ($model->fileAmv == Null) {
                return $this->redirect(['pic_error']);
            }
            $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
            $model->folder;
            $model->preview_url = '/'. $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension;
            $model->user_id = Yii::$app->user->identity->id;
            $model->videos_id = Yii::$app->session->get('idVideo');
            $model->save();
            $model->fileAmv->saveAs('files/' . $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension);

            return $this->redirect(['upload_direct']);
        } else {
            return $this->render('upload_preview', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpload_direct()
    {
        $model = new Direct();

        if ( $model->load(Yii::$app->request->post()) ) {

            $model->user_id = Yii::$app->user->identity->id;
            $model->videos_id = Yii::$app->session->get('idVideo');
            $model->save();
            return $this->redirect(['profile/videos']);

        } else {
            return $this->render('upload_direct', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findOnevideo($id)->delete();

        return $this->redirect(['profile/videos']);
    }

    public function actionVideos()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Videos::find()->where(['author_id'=>Yii::$app->user->identity->getId()])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('videos',
            ['listDataProvider' => $dataProvider]
        );
    }

    public function actionUpdate()
    {
        $model = $this->findModel();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    private function findModel()
    {
        return User::findOne(Yii::$app->user->identity->getId());
    }

    public function actionVideos_info($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Videos_category::find()->where(['videos_id' => $id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        return $this->render('videos_info', [
            'model' => $this->findOnevideo($id),
            'listDataProvider' => $dataProvider
        ]);
    }

    public function actionUpdate_videos($id)
    {
        $model = $this->findOnevideo($id);
        if($model->author_id !== Yii::$app->user->identity->id){return $this->redirect(['site/index']);}
            Yii::$app->session->set('idVideo', $model->id);

            return $this->render('update_videos', [
                'model' => $model,

            ]);
    }

    public function actionUpdate_videos_step1($id)
    {
        $model = Videos::findOne($id);

        $selectedCategory = $model->getSelectedCategory();
        $category = ArrayHelper::map(Category::find()->all(), 'id', 'cat_name');
        if($model->author_id !== Yii::$app->user->identity->id){return $this->redirect(['site/index']);}
        $model->updated_at = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {
            $model->fileImage = UploadedFile::getInstance($model, 'fileImage');
            if($model->fileImage){
                $current_image = $model->img;
                $dirname = __DIR__.'/../web/files/';
                $dir = $dirname.$current_image;
                if(file_exists($dir))
                {
                    //удаляем файл
                    unlink($dir);
                    $model->img = '';
                }
                $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                $model->folder;
                $model->img = $user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension;
                $category = Yii::$app->request->post('category');
                $model->save();

                $model->saveCategory($category);
                $model->fileImage->saveAs('files/' . $user->username . '/' . $model->fileImage->baseName . '.' . $model->fileImage->extension);
                return $this->redirect(['update_videos', 'id' => $model->id]);
            }
            else {
                $category = Yii::$app->request->post('category');
                if($model->save()){ $model->saveCategory($category);}
                return $this->redirect(['update_videos', 'id' => $model->id]);
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
        if($model->user_id !== Yii::$app->user->identity->id){return $this->redirect(['site/index']);}

        $local = Yii::$app->session->get('idVideo');
        $model->updated_at = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) ) {
            $model->fileAmv = UploadedFile::getInstance($model, 'fileAmv');
            if($model->fileAmv){

                $dirname = __DIR__.'/../web/files/';
                $dir = $dirname.$model->local_url;
                if (file_exists($dir)) {
                    unlink($dir);
                    $model->local_url = '';
                } else echo 'Нет такого файла';

                $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                $model->folder;
                $model->local_url = $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension;
                $model->user_id = Yii::$app->user->identity->id;
                $model->videos_id = $local;
                $model->check_id = Local::STATUS_PENDING;
                $model->save();

                $model->fileAmv->saveAs('files/' . $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension);
                return $this->redirect(['update_videos', 'id' => $local]);}
            else {
                $model->user_id = Yii::$app->user->identity->id;
                $model->videos_id = $local;
                $model->check_id = Local::STATUS_PENDING;
                $model->save();
                return $this->redirect(['update_videos', 'id' => $local]);
            }

        } else {
            return $this->render('update_videos_step2', [
                'model' => $model,
            ]);
        }

    }

    public function actionUpdate_videos_step3($id)
    {
        $model = $this->findOnepreview($id);
        if($model->user_id !== Yii::$app->user->identity->id){return $this->redirect(['site/index']);}
        $model->updated_at = date("Y-m-d H:i:s");
            $local = Yii::$app->session->get('idVideo');
            if ($model->load(Yii::$app->request->post()) ) {
                $model->fileAmv = UploadedFile::getInstance($model, 'fileAmv');
                if ($model->fileAmv) {

                    $dirname = __DIR__ . '/../web/files/';
                    $dir = $dirname . $model->preview_url;
                    if (file_exists($dir)) {
                        unlink($dir);
                        $model->preview_url = '';
                    } else echo 'Нет такого файла';

                    $user = User::find()->where(['id' => Yii::$app->user->identity->id])->one();
                    $model->folder;
                    $model->preview_url = $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension;
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->videos_id = $local;
                    $model->check_id = Preview::STATUS_PENDING;
                    $model->save();

                    $model->fileAmv->saveAs('files/' . $user->username . '/' . $model->fileAmv->baseName . '.' . $model->fileAmv->extension);
                    return $this->redirect(['update_videos', 'id' => $local]);
                } else {
                    $model->user_id = Yii::$app->user->identity->id;
                    $model->videos_id = $local;
                    $model->check_id = Preview::STATUS_PENDING;
                    $model->save();
                    return $this->redirect(['update_videos', 'id' => $local]);
                }
            }

         else {
            return $this->render('update_videos_step3', [
                'model' => $model,
            ]);
        }

    }
    public function actionUpdate_videos_step4($id)
    {
        $model = $this->findOnedirect($id);

        if($model->user_id !== Yii::$app->user->identity->id){return $this->redirect(['site/index']);}
        $model->updated_at = date("Y-m-d H:i:s");
        $local = Yii::$app->session->get('idVideo');
        $model->check_id = Direct::STATUS_PENDING;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update_videos', 'id' => $local]);
        } else {
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

    protected function findOnevideo($id)
    {
        return Videos::findOne($id);
    }
    protected function findOnelocal($id)
    {
        return Local::findOne($id);
    }
    protected function findOnepreview($id)
    {
        return Preview::findOne($id);
    }
    protected function findOnedirect($id)
    {
        return Direct::findOne($id);
    }

}
