<?php
namespace frontend\controllers;

use frontend\models\Category;
use frontend\models\Wishlist;
use Yii;
use yii\filters\AccessControl;
use frontend\models\Videos;
use frontend\models\User;
use frontend\models\Videos_category;
use frontend\models\VidComments;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use frontend\models\Local;
use frontend\models\Preview;
use frontend\models\Direct;
use frontend\models\Comments;
use frontend\models\SearchForm;
use yii\helpers\Html;


/**
 * PostsController implements the CRUD actions for Posts model.
 */
class VideosController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
        $question = new SearchForm();
        if ($question->load(Yii::$app->request->get()) && $question->validate())
        {
            $q = Html::encode($question->q);
            return $this->redirect(Yii::$app->urlManager->createUrl(['site/search', 'q' => $q]));
        }
        $dataProvider = new ActiveDataProvider([
            'query' => Videos::find()->where(['availability'=>Videos::STATUS_APPROVED])->andWhere(['status'=>Videos::STATUS_ON])->orderBy('created_at DESC'),
            'pagination' => [
                'pageSize' => 9,
            ],
        ]);
        $this->view->title = 'Клипы';
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Музыкальные аниме клипы.'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'AMV, online, HD, аниме, клипы, музыка, видео, АМВ, кино, Naruto, Evangelion, Bleach, Наруто, Евангелион, видеоклипы, манга, конкурсы, скачать, бесплатно, смотреть, торрент, download, torrent, онлайн'
        ]);
        return $this->render('index', ['listDataProvider' => $dataProvider,
          'question' => $question]);
    }

    public function actionView($id)
    {
        if ((Videos::findOne($id)) == null) {return $this->redirect(['site/error']);}
        $model = Videos::findOne($id);
        if($model->status !== Videos::STATUS_ON){return $this->redirect(['site/error']);}

        $dataProvider = new ActiveDataProvider([
            'query' => Videos_category::find()->where(['videos_id'=>$id])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $com = new Comments();
        if ($com->load(Yii::$app->request->post()) && $com->save() ) {
            $vid_comments = new VidComments();
            $user_id = Yii::$app->user->identity->id;
            $vid_comments->videos_id = $model->id;
            $vid_comments->author_id = $user_id;
            $vid_comments->comment_id = $com->id;
            $vid_comments->save();
            $user = User::findOne($user_id);
            $user->updateCounters(['karma' => 50]);
            $this->refresh();
        }else{
        return $this->render('view', [
            'model' => $model,
            'listDataProvider' => $dataProvider,
        ]);}

    }

    protected function findModel($id)
    {

        if (($model = Videos::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }

    public function actionCategory($id)
    {
        $model = $this->findModel($id);
        return $this->render('category', [
            'model' => $model
        ]);

    }

    public function actionViewlocal($id, $mirror = null)
    {
        Yii::$app->session->set('idLocal', $mirror);
        return $this->render('viewlocal', [
            'model' => $this->findModellocal($id)
        ]);
    }

    public function actionViewpreview($id, $mirror = null)
    {
        $video_name = Videos::find()->where(['id' => $this->findModelpreview($id)->videos_id])->one();
        Yii::$app->session->set('idPreview', $mirror);
        return $this->render('viewpreview', [
            'model' => $this->findModelpreview($id),
            'video_name' => $video_name
        ]);
    }

    public function actionDownload_local($id)
    {
        return $this->render('download_local', [
            'model' => $this->findModellocal($id)
        ]);
    }

    public function actionDownload_preview($id)
    {
        return $this->render('download_preview', [
            'model' => $this->findModelpreview($id)
        ]);
    }

    public function actionViewdirect($id)
    {
        $video_name = Videos::find()->where(['id' => $this->findModeldirect($id)->videos_id])->one();
        return $this->render('viewdirect', [
            'model' => $this->findModeldirect($id),
            'video_name' => $video_name
        ]);
    }

    public function actionAddWish($videos_id)
    {
        $wishlist = Wishlist::find()->where(['videos_id' => $videos_id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one();
        if($wishlist) {
            Yii::$app->session->setFlash('error', 'Ошибка. Клип уже в Избранном');
            return $this->redirect(['videos/view', 'id' => $videos_id]);
        } else $wishlist = new Wishlist();

        $wishlist->videos_id = $videos_id;
        $wishlist->user_id = Yii::$app->user->identity->id;
        if($wishlist->save()) Yii::$app->session->setFlash('success', 'Клип добавлен в Избранное');
        else Yii::$app->session->setFlash('error', 'Ошибка при добавлении клипа в Избранное');

        return $this->redirect(['videos/view', 'id' => $videos_id]);
    }

    public function actionDeleteWish($videos_id)
    {
        $wishlist = Wishlist::find()->where(['videos_id' => $videos_id])->andWhere(['user_id' => Yii::$app->user->identity->id])->one();

        if($wishlist) {
            $wishlist->delete();
            Yii::$app->session->setFlash('success', 'Клип успешно убран из Избранного');
        }
        else Yii::$app->session->setFlash('error', 'Ошибка при удадении клипа из Избранного');

        return $this->redirect(['videos/view', 'id' => $videos_id]);
    }

    protected function findModellocal($id)
    {
        if (($model = Local::findOne($id)) !== null ) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }

    protected function findModelpreview($id)
    {
        if (($model = Preview::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }

    protected function findModeldirect($id)
    {
        if (($model = Direct::findOne($id)) !== null) {
            return $model;
        } else {
            return $this->redirect(['site/error']);
        }
    }


}
