<?php

namespace frontend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "faqs".
 *
 * @property integer $idGroups
 * @property string $groupsName
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class Faqs extends ActiveRecord
{

    const STATUS_PENDING=0;
    const STATUS_APPROVED=1;
    const STATUS_SITE=1;
    const STATUS_PROFILE=2;
    const STATUS_AMV=3;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faqs}}';
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

        ];
    }

    public function getCatName(){
        if($this->cat_id == 1){$catName = 'Все вопросы про сайт';}
        if($this->cat_id == 2){$catName = 'Вопросы о профиле';}
        if($this->cat_id == 3){$catName = 'Вопросы о клипах';}
        return $catName;
    }

    public function getMiniText(){
        $text = mb_substr($this->text, 0, 100).'...';
        return $text;
    }

}