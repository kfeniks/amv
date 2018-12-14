<?php
namespace frontend\controllers;

use Yii;
use frontend\models\Videos_category;
use frontend\models\Videos;
use frontend\models\User;
use frontend\models\Category;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\filters\AccessControl;




/**
 * PostsController implements the CRUD actions for Posts model.
 */
class CategoryController extends Controller
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

        $dataProvider = new ActiveDataProvider([
            'query' => Category::find()->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        $this->view->title = 'Категории клипов';
        return $this->render('index', ['listDataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        if (($model = Category::findOne($id)) !== null) {
        $cat = Category::findOne($id);
        $catName = $cat->cat_name;
        $this->view->title = 'Список клипов категории'. $catName;

            $model = Videos_category::find()->where(['category_id'=>$id])->orderBy('id DESC');
          //  $video = Videos::find()->where(['availability'=>Videos::STATUS_APPROVED])->andWhere(['status'=>Videos::STATUS_ON])->andWhere(['id'=>$model->videos_id]);
            $dataProvider = new ActiveDataProvider([
                'query' => $model,
                'pagination' => [
                    'pageSize' => 6,
                ],
            ]);

        return $this->render('view', [
            'listDataProvider' => $dataProvider,
            'catName' => $catName,
        ]);

        } else {
            return $this->redirect(['site/error']);
        }
    }

}
