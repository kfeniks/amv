<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "opinion".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Opinion extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'opinion';
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
        return $this->hasOne(Videos::className(), ['id' => 'opinion_id']);
    }

}
