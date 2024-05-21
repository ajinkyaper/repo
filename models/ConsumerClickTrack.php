<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "consumer_click_track".
 *
 * @property int $id
 * @property int $speedrail_id
 * @property int $brand_id
 * @property int $click_count
 * @property string|null $created_at
 */
class ConsumerClickTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'consumer_click_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speedrail_id', 'brand_id'], 'required'],
            [['click_count'], 'safe']
        ];
    }
}
