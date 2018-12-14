<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;


/**
 * This is the model class for table "IpBehavior".
 *
 * @property integer $id
 * @property array $user
 * @property array $myCheck
 * @property array $ipUser
 * @property string
 * @property integer
 * @property integer
 * @property integer
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
        echo '<div class="inner">';
        foreach ($ipUser as $ips) {

            $user = self::find()->where(['ip'=>$ips->ip])->count();
            if($user >= 2){
                $userCheck = self::find()->where(['ip'=>$ips->ip])->all();
                $id = $userCheck->user_id;
                foreach ($userCheck as $userCheckIp) {
                    if($userCheckIp->user_id !== $id && $myCheck !== null && $myCheck !== $userCheckIp->ip){$myCheck = $userCheckIp->ip; echo '<h3>'.$myCheck.'</h3>';}
                }

            }
        }
        echo '<p>Поиск мультиводов по ip</p></div>';
    }

}
