<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "market".
 *
 * @property int $id
 * @property string $price
 */
class PriceRange extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'price_range';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['price', 'required']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'price' => 'Price Range',
        ];
    }
}
