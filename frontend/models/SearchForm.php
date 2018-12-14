<?php
namespace frontend\models;

use yii\base\Model;

class SearchForm extends Model
{
    public $q;

    public function rules()
    {
        return [
            ['q', 'string', 'min' => 3, 'max' => 250],
            [['q'], 'required', 'message'=>'{attribute} не может быть пустым'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'q' => 'Поиск',
        ];
    }
}

?>