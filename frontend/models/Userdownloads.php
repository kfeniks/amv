<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use common\models\User;


/**
 * This is the model class for table "category".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Userdownloads extends ActiveRecord
{

    const STATUS_NOOPINION=0;
    const STATUS_OPINION=1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_downloads';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getVideos()
    {
        return $this->hasOne(Videos::className(), ['id' => 'videos_id']);
    }

    public function checkStatus(){
        $downloadsStatus = self::find()->where(['id' => $this->id])->andwhere(['status' => self::STATUS_NOOPINION])->one();
        $rank = Rankusers::find()->where(['videos_id' => $this->videos_id])->andwhere(['user_id' => $this->user_id])->one();
        if ($downloadsStatus == Null) { echo 'Вы уже дали оценку '.$rank->rank_id;}
        else{return $this->makeUserOpinion();}
    }

    public function makeUserOpinion(){
        $rating = '<div class="rating"><div class="stars">';
        $ratingStart = '<div class="on" style="width: 0%;"></div> <div class="live">';
        $ratingEnd = '</div></div></div>';


        $link1 = '<a data-rate="1" href="'.Yii::$app->urlManager->createUrl(["downloads/rank", "id" => 1, "videos_id" => $this->videos_id]).'" ></a>';
        $link2 = '<a data-rate="2" href="'.Yii::$app->urlManager->createUrl(["downloads/rank", "id" => 2, "videos_id" => $this->videos_id]).'" ></a>';
        $link3 = '<a data-rate="3" href="'.Yii::$app->urlManager->createUrl(["downloads/rank", "id" => 3, "videos_id" => $this->videos_id]).'" ></a>';
        $link4 = '<a data-rate="4" href="'.Yii::$app->urlManager->createUrl(["downloads/rank", "id" => 4, "videos_id" => $this->videos_id]).'" ></a>';
        $link5 = '<a data-rate="5" href="'.Yii::$app->urlManager->createUrl(["downloads/rank", "id" => 5, "videos_id" => $this->videos_id]).'" ></a>';
        $link =  $rating.$ratingStart.$link1.$link2.$link3.$link4.$link5.$ratingEnd;
        return $link;
    }

    public function getUserName(){
        $userName = User::find()->where(['id'=>$this->user_id])->one();
        $name = $userName->username;
        return $name;

    }
    public function getVideoName(){
        $videoName = Videos::find()->where(['id'=>$this->videos_id])->one();
        $name = $videoName->title;
        return $name;
    }
    public function getStatus(){
        if ($this->status == self::STATUS_NOOPINION)
        {echo '<span class="badge badge-success">ожидает оценки</span>';}
        else  echo '';
    }
}
