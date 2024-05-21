<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "click_track".
 *
 * @property int $id
 * @property int $pro_id
 * @property int $edu_id
 * @property int $brand_id 
 * @property string $user_random_id
 * @property string $click_date
 */
class ClickTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'click_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pro_id', 'edu_id', 'cocktail_id', 'marque_id', 'brand_id'], 'integer'],
            [['click_date'], 'safe'],
            [['user_random_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pro_id' => 'Pro ID',
            'edu_id' => 'Edu ID',
            'user_random_id' => 'User Random ID',
            'click_date' => 'Click Date',
        ];
    }
}
