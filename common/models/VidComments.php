<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "vid_comments".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class VidComments extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'vid_comments';
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

    public function getComments()
    {
        return $this->hasMany(Comments::className(), ['id' => 'comment_id']);
    }

    public function getUser()
    {
        return $this->hasMany(User::className(), ['id' => 'author_id']);
    }


}
