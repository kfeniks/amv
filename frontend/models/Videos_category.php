<?php

namespace frontend\models;
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

class Videos_category extends ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'videos_category';
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

    public function getCategory()
    {
        return $this->hasMany(Category::className(), ['id' => 'category_id']);
    }

    public function getcatName(){
        $catName = Category::findOne($this->category_id);
        return $catName->cat_name;
    }

}
