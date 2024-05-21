<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categories;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class CategorySearch extends Categories
{
    /**
     * {@inheritdoc}
     */
    public $activeRecordsCounts = 0;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['category_name'], 'safe'],
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
        $query = Categories::find();


        // add conditions that should always apply here
        $query->innerJoinWith(['user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
            //'sort' =>false
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
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'category_name', $this->category_name]);

        // $countQuery->andFilterWhere([
        //     'id' => $this->id,
        //     'status' => $this->status,
        // ]);

        // $countQuery->andFilterWhere(['like', 'category_name', $this->category_name]);
        // $dataProvider->totalCount = $countQuery->andFilterWhere(['=', 'status', 1])->count();
        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'categories.status', 1])->groupBy('categories.id')->count();
        $this->activeRecordsCounts = $count;

        return $dataProvider;
    }
}
