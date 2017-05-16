<?php

namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;


/**
 * This is the model class for table "category".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Ip extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'IpBehavior';
    }

    public function rules()
    {
        return [

        ];
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
    public function getIpcheck()
    {
        $user = self::find()->where(['user_id'=>$this->user_id])->orderBy('id DESC')->all();
        foreach ($user as $ip){
        echo'<div class="row">';
echo'<div class="col-md-3">'. HtmlPurifier::process(Yii::$app->formatter->asDate($ip->date, 'd MMMM yyyy')).'</div>';
            echo'<div class="col-md-3">'. $ip->ip .'</div>';
            echo'<div class="col-md-3">'. $ip->host .'</div>';

            echo'</div>';
     }

    }

    public function getIpmulti()
    {
        $myCheck = '';
        $ipUser = self::find()->all();
        echo '<div class="container white home"><h3>Поиск мультиводов по ip:</h3>';
        foreach ($ipUser as $ips) {

            $user = self::find()->where(['ip'=>$ips->ip])->count();
            if($user >= 2){
                $userCheck = self::find()->where(['ip'=>$ips->ip])->all();
                $id = $userCheck->user_id;
                foreach ($userCheck as $userCheckIp) {
                    if($userCheckIp->user_id !== $id && $myCheck !== null && $myCheck !== $userCheckIp->ip){$myCheck = $userCheckIp->ip;echo $myCheck.'<br>';}
                }

            }
        }
        echo '</div>';
    }



}
