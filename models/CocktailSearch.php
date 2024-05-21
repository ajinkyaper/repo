<?php

namespace app\models;

use yii\base\Model;

use yii\data\ActiveDataProvider;
use app\models\Cocktail;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class CocktailSearch extends Cocktail
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
            [['id', 'is_active'], 'integer'],
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
        $query = Cocktail::find();
        // $query->select('cocktail.name', 'brands.brand_name', 'cocktail.id', 'cocktail.created_at', 'cocktail.updatd_at');
        $query->innerJoinWith(['marques' => function ($query) {
            $query->innerJoinWith('brand');
        },]);
        $query->innerJoinWith(['cocktailOccasion' => function ($query) {
            $query->innerJoinWith('occasion');
        }]);
        $query->innerJoinWith(['user']);
        // $query->joinWith(['marques.brand']);
        //$query->joinWith(['cocktailOccasion.occasion']);
        // add conditions that should always apply here


        // $countQuery = Cocktail::find();
        // $countQuery->joinWith(['marques.brand']);
        // $countQuery->joinWith(['cocktailOccasion.occasion']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'brand_name', 'updated_at', 'is_active'],
                'defaultOrder' => ['updated_at' => SORT_DESC, 'name' => SORT_ASC]
            ]
        ]);

        // $dataProvider->sort->defaultOrder = array('name'=>CSort::SORT_ASC);
        //     $dataProvider->sort->attributes['name'] = [
        //     'asc' => ['name' => SORT_ASC],
        //     'desc' => ['name' => SORT_DESC],
        // ];
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'is_active' => $this->is_active,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'brand_details.brand_name', $this->brand_name])
            ->andFilterWhere(['like', 'cocktail.name', $this->name])
            ->andFilterWhere(['like', 'occasions_v3.name', $this->occ_name])
            ->groupBy('cocktail.id');

        // $count = $countQuery->andFilterWhere(['like', 'brand_details.brand_name', $this->brand_name])
        // ->andFilterWhere(['like', 'cocktail.name', $this->name])
        // ->andFilterWhere(['like', 'occasions_v3.name', $this->occ_name])
        // ->andFilterWhere(['=', 'cocktail.is_active', 1])
        // ->groupBy('cocktail.id')->count();
        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'cocktail.is_active', 1])->groupBy('cocktail.id')->count();
        $this->activeRecordsCounts = $count;

        return $dataProvider;
    }

    public function updatedData($last_date)
    {
        $query = Cocktail::find()->where(['>=', 'cocktail.updated_at', $last_date]);
        $query->joinWith(['marques.brand']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name', 'brand_name', 'updated_at', 'is_active'],
                'defaultOrder' => ['updated_at' => SORT_ASC, 'name' => SORT_ASC]
            ]
        ]);
        return $dataProvider;
    }
}
