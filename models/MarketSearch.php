<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Market;

/**
 * MarketSearch represents the model behind the search form of `app\models\MArkets`.
 */
class MarketSearch extends Market
{
    /**
     * {@inheritdoc}
     */

    public $activeRecordsCounts = 0;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Market::find();
        $this->load($params);
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ]);

        
        // add conditions that should always apply here
        $query->innerJoinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['name', 'updated_at', 'status']],

        ]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere(['like', 'market.name', $this->name]);
        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'market.status', 1])->groupBy('market.id')->count();
        $this->activeRecordsCounts = $count;
        return $dataProvider;
    }
}
