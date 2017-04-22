<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\data\Pagination;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use frontend\models\Videos;
use frontend\models\Messages;
use frontend\models\Usernews;
use frontend\models\IpBehavior;
use frontend\models\Userdownloads;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'home', 'homefaqs', 'myclips'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['home'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['homefaqs'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['contact'],
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

    /**
     * @inheritdoc
     */

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        Yii::$app->view->registerMetaTag([
            'name' => 'description',
            'content' => 'Аниме музыкальные клипы (AMV) содержат анимационные клипы с аудио треком. Это созданные фанатами аниме видеоклипы, которые распространяются во всем интернет пространстве, например, на YouTube. Пытаетесь сделать AMV, но не можете найти нужные клипы? Отлично, это должно помочь вам в этом и даже больше!'
        ]);
        Yii::$app->view->registerMetaTag([
            'name' => 'keywords',
            'content' => 'AMV, online, HD, аниме, клипы, музыка, видео, АМВ, кино, Naruto, Evangelion, Bleach, Наруто, Евангелион, видеоклипы, манга, конкурсы, скачать, бесплатно, смотреть, торрент, download, torrent, онлайн'
        ]);
        $model = Videos::find()->where(['availability' => Videos::STATUS_APPROVED])->andwhere(['award_month' => Videos::STATUS_APPROVED])->limit(3)->all();

        return $this->render('index',
            [
                'model' => $model,
            ]);
    }

    public function actionSearch(){
        $q = trim(Yii::$app->request->get('q'));
        $this->view->title = 'AMV.PP.UA | Поиск: '.$q;
        if(!$q){
           return $this->redirect(Yii::$app->urlManager->createUrl(['site/index']));
        //    return $this->render('search');
        }
        $query = Videos::find()->where(['like', 'title', $q])->orWhere(['like', 'comments', $q])->orWhere(['like', 'meta_key', $q]);
        $pages = new Pagination([
           'totalCount' => $query->count(),
            'pageSize' => 20,
            'forcePageParam' => false,
            'pageSizeParam' => false
        ]);
        $videos = $query->orderBy('id DESC')
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('search', compact('videos', 'pages'));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $IpBehavior = new IpBehavior();
            $IpBehavior->ip = Yii::$app->request->userIP;
            $IpBehavior->host = Yii::$app->request->userHost;
            $IpBehavior->user_id = Yii::$app->user->identity->getId();
            $IpBehavior->save();
            return $this->redirect(['site/home']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Спасибо, мой друг, что написал мне. Тебе придет ответ так быстро, как только я смогу.');
            } else {
                Yii::$app->session->setFlash('error', 'Странно, но возникли проблемы при отправке твоего сообщения.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionHome()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => Videos::find()->where(['award_week' => '1', 'availability' => 1])->with(['user'])->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $messages_user = Messages::find()->where(['user_id_to' => Yii::$app->user->identity->getId()])->one();
        $video_user = Videos::find()->where(['author_id' => Yii::$app->user->identity->getId(), 'availability' => 1])->orderBy('id DESC')->limit(5)->all();
        $usernews = Usernews::find()->where(['hide'=>Usernews::STATUS_APPROVED])->orderBy('date_create DESC')->limit(5)->all();
        $downloads = Userdownloads::find()->where(['user_id' => Yii::$app->user->identity->id])->andwhere(['status' => Userdownloads::STATUS_NOOPINION])->all();
                return $this->render('home', ['listDataProvider' => $dataProvider,
                        'messages_user' => $messages_user,
                        'video_user' => $video_user,
                        'usernews' => $usernews,
                        'downloads' => $downloads,
            ]

    );
    }

    public function actionHomefaqs()
    {
        return $this->render('homefaqs');
    }


    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

}
