<?php

namespace app\models;

use Yii;


use yii\base\Model;

use yii\data\ActiveDataProvider;
use app\models\EducatorActivityTrack;

class EducatorActivityTrackSearch extends EducatorActivityTrack
{
    /**
     * {@inheritdoc}
     */
    public $edu_name;
    public static function tableName()
    {
        return 'educator_activity_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'activity'], 'required'],
            [['pin_downloaded', 'pin_returned', 'device_id', 'edu_name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }


    public function search($params)
    {
        $query = EducatorActivityTrack::find();
        // $query->select('cocktail.name', 'brands.brand_name', 'cocktail.id', 'cocktail.created_at', 'cocktail.updatd_at');
        $query->joinWith(['educators' => function ($query) {
            $query->joinWith('market');
        }]);
        //$query->joinWith(['market']);
        // $query->joinWith(['cocktailOccasion.occasion']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ],
                'attributes' => ['edu_name', 'market', 'activity', 'created_at']
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
        // $query->andFilterWhere([
        //     'id' => $this->id,
        //     'is_a' => $this->is_active,
        //     'updated_at' => $this->updated_at,
        // ]);

        $query->andFilterWhere(['like', 'educators.edu_name', $this->brand_name])
            ->andFilterWhere(['like', 'market_name', $this->market_name]);
        // ->andFilterWhere(['like', 'occasions_v3.name', $this->occ_name]);

        return $dataProvider;
    }
}
