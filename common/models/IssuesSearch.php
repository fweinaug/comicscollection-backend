<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Issues;

/**
 * IssuesSearch represents the model behind the search form of `common\models\Issues`.
 */
class IssuesSearch extends Issues
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'comic_id', 'number', 'image_id'], 'integer'],
            [['title', 'summary', 'created_at'], 'safe'],
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
        $query = Issues::find()->joinWith('comic');

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
            'comic_id' => $this->comic_id,
            'number' => $this->number,
            'image_id' => $this->image_id,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'summary', $this->summary]);

        return $dataProvider;
    }
}
