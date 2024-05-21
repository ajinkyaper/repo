<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Educators;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class EducatorsSearch extends Educators
{
    /**
     * {@inheritdoc}
     */
    public $edu_name;
    public $name;
    public $email;
    public $Markets;
    
    public $activeRecordsCounts = 0;
    public function rules()
    {
        return [
            [['edu_id', 'status'], 'integer'],
            [['edu_name', 'name', 'email', 'Markets'], 'safe'],
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

        $query = Educators::find();


        $query->innerJoinWith(['market']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['edu_name', 'name', 'status', 'email']]
            // 'sort'=> ['defaultOrder' => ['category_name'=>SORT_ASC]]
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
            'edu_id' => $this->edu_id,
            'status' => $this->status,
        ]);




        $query->andFilterWhere(['like', 'educators.edu_name', $this->edu_name])
            // ->andFilterWhere(['like', 'market.name', $this->name])
            ->andFilterWhere(['educators.city' => $this->Markets])
            ->andFilterWhere(['like', 'educators.email', $this->email]);

        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'educators.status', 1])->groupBy('educators.edu_id')->count();
        $this->activeRecordsCounts = $count;
        // $countQuery = Educators::find();
        // $countQuery->joinWith(['market']);
        // $countQuery->andFilterWhere([
        //     'edu_id' => $this->edu_id,
        //     'status' => $this->status,
        // ]);
        // $countQuery->andFilterWhere(['like', 'educators.edu_name', $this->edu_name])
        //     ->andFilterWhere(['educators.city' => $this->Markets])
        //     ->andFilterWhere(['like', 'educators.email', $this->email]);

        // $dataProvider->totalCount = $countQuery->count();
        return $dataProvider;
    }
}
