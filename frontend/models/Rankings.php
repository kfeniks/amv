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

class Rankings extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%rankings}}';
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
        return $this->hasMany(Videos::className(), ['id' => 'videos_id'])
            ->viaTable('rank_users', ['rank_id'=> 'id']);
    }

}
