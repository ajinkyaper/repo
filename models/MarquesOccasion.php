<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marques_occasion".
 *
 * @property int $id
 * @property int $occasion_id
 * @property int $marques_id
 */
class MarquesOccasion extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marques_occasion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occasion_id', 'marques_id'], 'required'],

        ];
    }

    public function getOccasion()
    {
        return $this->hasOne(OccasionV3::class, ['id' => 'occasion_id']);
    }
}
