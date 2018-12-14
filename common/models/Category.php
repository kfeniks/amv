<?php

namespace common\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Category extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
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
            ->viaTable('videos_category', ['category_id'=> 'id']);
    }
    public function getVidcategory()
    {
        return $this->hasOne(Videos_category::className(), ['category_id' => 'id']);
    }

    public function getcatCount(){

        $catCount = Videos_category::find()->where(['category_id'=>$this->id])->count();
        return $catCount;
    }
//    public static function listAll($keyField = 'id', $valueField = 'cat_name', $asArray = true)
//    {
//        $query = static::find()->where(['status' => 1]);
//        if ($asArray) {
//            $query->select([$keyField, $valueField])->asArray();
//        }
//
//        return ArrayHelper::map($query->all(), $keyField, $valueField);
//    }

}
