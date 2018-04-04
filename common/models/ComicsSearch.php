<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Comics;

/**
 * ComicsSearch represents the model behind the search form of `common\models\Comics`.
 */
class ComicsSearch extends Comics
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'image_id', 'publisher_id', 'issues_total', 'concluded'], 'integer'],
            [['name', 'created_at'], 'safe'],
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
        $query = Comics::find();

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
            'image_id' => $this->image_id,
            'publisher_id' => $this->publisher_id,
            'issues_total' => $this->issues_total,
            'concluded' => $this->concluded,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
