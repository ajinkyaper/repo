<?php

namespace app\models;

use yii\base\Model;

use yii\data\ActiveDataProvider;
use app\models\MomentV3;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class MomentV3Search extends MomentV3
{
    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    public $activeRecordsCounts = 0;
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
        $query = MomentV3::find();
        // $query->select('cocktail.name', 'brands.brand_name', 'cocktail.id', 'cocktail.created_at', 'cocktail.updatd_at');
        // $query->joinWith(['marques.brand']);
        // $query->joinWith(['cocktailOccasion.occasion']);
        // add conditions that should always apply here

        $query->innerJoinWith(['user']);
        // $countQuery = MomentV3::find();

        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'moments_v3.status', 1])->groupBy('moments_v3.id')->count();
        $this->activeRecordsCounts = $count;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name',  'updated_at'],
                'defaultOrder' => ['name' => SORT_ASC]
            ]
        ]);

        //$dataProvider->sort->defaultOrder = array('name'=> CSort::SORT_ASC);
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
        return $dataProvider;
    }
}
