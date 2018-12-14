<?php

namespace common\models;
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

class Comments extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['text'], 'required', 'message'=>'{attribute} не может быть пустым'],
            [['text'], 'string', 'min' => 5, 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'text' => 'Ваш комментарий',
        ];
    }

    public function getVideos()
    {
        return $this->hasMany(Videos::className(), ['id' => 'videos_id'])
            ->viaTable('vid_comments', ['comment_id'=> 'id']);
    }

    public function getVidComments()
    {
        return $this->hasMany(VidComments::className(), ['comment_id' => 'id']);
    }

}
