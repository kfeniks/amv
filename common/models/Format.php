<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "format".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Format extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'format';
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
        return $this->hasMany(Local::className(), ['id' => 'format_id']);
    }
    public function getPreview()
    {
        return $this->hasMany(Preview::className(), ['id' => 'format_id']);
    }
    public function getDirect()
    {
        return $this->hasMany(Direct::className(), ['id' => 'format_id']);
    }
    public static function listAll($keyField = 'id', $valueField = 'name', $asArray = true)
    {
        $query = static::find();
        if ($asArray) {
            $query->select([$keyField, $valueField])->asArray();
        }

        return ArrayHelper::map($query->all(), $keyField, $valueField);
    }
}
