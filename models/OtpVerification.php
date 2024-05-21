<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "otp_verification".
 *
 * @property int $id
 * @property int $edu_id
 * @property int $otp
 * @property string $generated_time
 *
 * @property Educators $edu
 */
class OtpVerification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otp_verification';
    }

    public $email;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'otp'], 'integer', 'except' => ['api']],
            [['email', 'otp'], 'required', 'on' => 'api'],
            ['email', 'email', 'on' => 'api'],
            ['otp', 'validateOtp'],
            [['generated_time'], 'safe'],
            [['edu_id'], 'exist', 'skipOnError' => true, 'targetClass' => Educators::class, 'targetAttribute' => ['edu_id' => 'edu_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edu_id' => 'Edu ID',
            'otp' => 'Otp',
            'generated_time' => 'Generated Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdu()
    {
        return $this->hasOne(Educators::class, ['edu_id' => 'edu_id']);
    }

    public function validateOtp($attribute)
    {
        if (!preg_match('/^[0-9]{6}$/', $this->otp)) {
            $this->addError('otp', 'Invalid OTP.');
        }
    }
}
