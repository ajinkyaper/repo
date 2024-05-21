<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cocktail_occasion".
 *
 * @property int $id
 * @property int $occasion_id
 * @property int $cocktail_id
 */
class CocktailOccasion extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cocktail_occasion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occasion_id', 'cocktail_id'], 'required'],

        ];
    }

    public function getOccasion()
    {
        return $this->hasOne(OccasionV3::class, ['id' => 'occasion_id']);
    }
}
