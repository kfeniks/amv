<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "check_vid".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class CheckVid extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'check_vid';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getLocal()
    {
        return $this->hasMany(Local::className(), ['check_id' => 'id']);
    }
    public function getPreview()
    {
        return $this->hasMany(Preview::className(), ['check_id' => 'id']);
    }
    public function getDirect()
    {
        return $this->hasMany(Direct::className(), ['check_id' => 'id']);
    }
    public static function listAll($keyField = 'id', $valueField = 'check_name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }
}
