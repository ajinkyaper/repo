<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Marques;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class MarquesSearch extends Marques
{
    /**
     * {@inheritdoc}
     */
    public $brand_name;
    public $name;
    public $occasion_name;
    public $occ_name;
    public $activeRecordsCounts = 0;
    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['name', 'created_at', 'updated_at', 'brand_name', 'occ_name'], 'safe'],
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
        $query = Marques::find();
        $query->innerJoinWith('brand');

        //$query->joinWith(['brand']);
        $query->joinWith(['marquesOccasion' => function ($query) {
            $query->joinWith('occasion');
        }]);
        $query->innerJoinWith('user');
        // $countQuery = Marques::find();
        // $countQuery->joinWith(['brand']);
        // $countQuery->joinWith(['marquesOccasion.occasion']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['name', 'brand_name', 'updated_at', 'status'], 'defaultOrder' => ['updated_at' => SORT_DESC]]
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
            'updated_at' => $this->updated_at
        ]);

        $query->andFilterWhere(['like', 'brand_details.brand_name', $this->brand_name]);
        $query->andFilterWhere(['like', 'marques.name', $this->name]);
        $query->andFilterWhere(['like', 'occasions_v3.name', $this->occ_name]);
        $query->groupBy('marques.id');
        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'marques.status', 1])->groupBy('marques.id')->count();
        $this->activeRecordsCounts = $count;
        // $countQuery->andFilterWhere(['like', 'brand_details.brand_name', $this->brand_name]);
        // $countQuery->andFilterWhere(['like', 'marques.name', $this->name]);
        // $countQuery->andFilterWhere(['like', 'occasions_v3.name', $this->occ_name]); 
        // $countQuery->andFilterWhere(['=', 'marques.status', 1])->groupBy('marques.id')->count();
        //$dataProvider->totalCount = $countQuery->andFilterWhere(['=', 'marques.status', 1])->groupBy('marques.id')->count();

        return $dataProvider;
    }
}
