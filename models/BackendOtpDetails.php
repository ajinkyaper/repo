<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "backend_otp_details".
 *
 * @property int $id
 * @property int $user_id
 * @property string $otp
 * @property string $generated_time
 * @property string $key
 * @property int $status
 */
class BackendOtpDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backend_otp_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'status','otp'], 'integer'],
            [['generated_time'], 'safe'],
            [['key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'otp' => 'Otp',
            'generated_time' => 'Generated Time',
            'key' => 'Key',
            'status' => 'Status',
        ];
    }
}
