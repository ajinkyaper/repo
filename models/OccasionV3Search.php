<?php

namespace app\models;

use yii\base\Model;

use yii\data\ActiveDataProvider;
use app\models\OccasionV3;

/**
 * CategorySearch represents the model behind the search form of `app\models\Categories`.
 */
class OccasionV3Search extends OccasionV3
{
    /**
     * {@inheritdoc}
     */


    /**
     * {@inheritdoc}
     */
    public $moment_name;
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
        $query = OccasionV3::find();

        $query->innerJoinWith(['moment', 'user']);
        //$query->select('occasions_v3.name', 'occasions_v3.id', 'occasions_v3.updated_at');
        // $query->joinWith(['marques.brand']);
        // $query->joinWith(['cocktailOccasion.occasion']);
        // add conditions that should always apply here
        // $countQuery = OccasionV3::find();
        // $countQuery->joinWith(['moment']);

        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'occasions_v3.status', 1])->groupBy('occasions_v3.id')->count();
        $this->activeRecordsCounts = $count;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => ['name',  'updated_at', 'moment_name'],
                'defaultOrder' => ['updated_at' => SORT_DESC]
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

        
        // $count = $countQuery->count();

        //$dataProvider->totalCount = $count;

        return $dataProvider;
    }
}
