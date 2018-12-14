<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;


/**
 * This is the model class for table "category".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Messages extends ActiveRecord
{

    const STATUS_PENDING=0;
    const STATUS_APPROVED=1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users_messages';
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

        return $this->hasOne(User::className(), ['id' => 'user_id_to']);
    }
    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['id' => 'user_id_from']);
    }

    public function isPending() {
        return $this->status == self::STATUS_PENDING;
    }

    public function getCheckStatus(){
        $check = '';
        if ($this->status == self::STATUS_PENDING)
        {$check = '<span class="badge badge-success">непрочитанное</span>';}
        return $check;
    }

    public function updateStatus(){
        $id = $this->id;
        Yii::$app->db->createCommand()->update('users_messages', ['status' => self::STATUS_APPROVED], 'id=:id')->bindParam(':id', $id)->execute();
    }
}
