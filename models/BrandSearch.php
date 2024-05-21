<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\BrandDetails;

/**
 * BrandSearch represents the model behind the search form of `app\models\BrandDetails`.
 */
class BrandSearch extends BrandDetails
{
    /**
     * {@inheritdoc}
     */
    public $activeRecordsCounts = 0;
    public function rules()
    {
        return [
            [['id', 'category_id', 'status', 'updated_by'], 'integer'],
            [['brand_name', 'created_at', 'updated_at'], 'safe'],
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
        $query = BrandDetails::find();

        // add conditions that should always apply here
        $query->innerJoinWith(['category', 'user']);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['updated_at' => SORT_DESC]]
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
            'category_id' => $this->category_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'brand_name', $this->brand_name]);
        $countQuery = clone $query;
        $count = $countQuery->andFilterWhere(['=', 'brand_details.status', 1])->groupBy('brand_details.id')->count();
        $this->activeRecordsCounts = $count;
        // $countQuery = BrandDetails::find();      
        // $countQuery->andFilterWhere([
        //     'id' => $this->id,
        //     'category_id' => $this->category_id,
        //     'status' => $this->status,
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        //     'updated_by' => $this->updated_by,
        // ]);

        //$countQuery->andFilterWhere(['like', 'brand_name', $this->brand_name]);

        //$dataProvider->totalCount = $countQuery->andFilterWhere(['=', 'status', 1])->count();
        return $dataProvider;
    }
}
