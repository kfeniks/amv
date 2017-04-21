<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "rankings".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Rankusers extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rank_users}}';
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
    public function getRankings()
    {
        return $this->hasMany(Rankings::className(), ['id' => 'rank_id']);
    }
    public function getRankName(){
        $rankName = Rankings::findOne($this->rank_id);
        return $rankName->rank_name;
    }
}
