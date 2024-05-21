<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "track".
 *
 * @property int $id
 * @property int $track_id
 * @property int $pro_id
 * @property string $event
 * @property string $added_on
 * @property int $user_random_id
 * @property int $edu_id
 */
class Track extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['track_id', 'pro_id', 'user_random_id'], 'required'],
            [['track_id', 'pro_id', 'user_random_id', 'edu_id'], 'integer'],
            [['added_on'], 'safe'],
            [['event'], 'string', 'max' => 255],
            [['track_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'track_id' => 'Track ID',
            'pro_id' => 'Pro ID',
            'event' => 'Event',
            'added_on' => 'Added On',
            'user_random_id' => 'User Random ID',
            'edu_id' => 'Edu ID',
        ];
    }
}
