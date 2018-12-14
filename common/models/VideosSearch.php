<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VideosSearch represents the model behind the search form about `common\models\Videos`.
 */
class VideosSearch extends Videos
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Videos::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'premiered' => $this->premiered,
            'author_id' => $this->author_id,
            'hits' => $this->hits,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'author_id', $this->author_id])
            ->andFilterWhere(['like', 'anime', $this->anime])
            ->andFilterWhere(['like', 'song', $this->song])
            ->andFilterWhere(['like', 'availability', $this->availability])
            ->andFilterWhere(['like', 'youtube', $this->youtube])
            ->andFilterWhere(['like', 'is_recommended', $this->is_recommended])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'opinion_id', $this->opinion_id])
            ->andFilterWhere(['like', 'award_week', $this->award_week])
            ->andFilterWhere(['like', 'award_month', $this->award_month]);

        return $dataProvider;
    }
}
