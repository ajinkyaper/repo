<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mail_track".
 *
 * @property int $id
 * @property string $user_random_id
 * @property int $edu_id
 * @property string $open_date
 */
class MailTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mail_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id'], 'integer'],
            [['open_date'], 'safe'],
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
            'user_random_id' => 'User Random ID',
            'edu_id' => 'Edu ID',
            'open_date' => 'Open Date',
        ];
    }
}
