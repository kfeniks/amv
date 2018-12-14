<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "comments".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Wishlist extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wishlist';
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

    public function getVideos()
    {
        return $this->hasOne(Videos::className(), ['videos_id' => 'id']);
    }
    public function getUser()
    {
        return $this->hasOne(User::className(), ['user_id' => 'id']);
    }

}
