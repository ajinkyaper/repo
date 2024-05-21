<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "trail_submissions".
 *
 * @property int $id
 * @property int $edu_id
 * @property string $req_time request date
 * @property string $status
 * @property string $user_random_id
 * @property string $mail_send_time
 * @property string $sub_date order submission date
 * @property int $sub_id submission id
 * @property int $is_pin
 * @property string $request_type type of submission (submit or reset)
 *
 * @property SubPro[] $subPros
 * @property SubmissionProducts[] $submissionProducts
 * @property Educators $edu
 */
class TrailSubmissions extends \yii\db\ActiveRecord
{

    const PENDING_STATUS = 'pending';
    const SEND_STATUS = 'send';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trail_submissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'sub_id', 'is_pin'], 'integer'],
            [['req_time', 'mail_send_time', 'sub_date', 'is_pin'], 'safe'],
            [['user_random_id'], 'required'],
            [['user_random_id'], 'string'],
            [['status'], 'string', 'max' => 10],
            [['request_type'], 'string', 'max' => 255],
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
            'req_time' => 'Req Time',
            'status' => 'Status',
            'user_random_id' => 'User Random ID',
            'mail_send_time' => 'Mail Send Time',
            'sub_date' => 'Sub Date',
            'sub_id' => 'Sub ID',
            'request_type' => 'Request Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubPros()
    {
        return $this->hasMany(SubPro::class, ['req_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubmissionProducts()
    {
        return $this->hasMany(SubmissionProducts::class, ['req_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdu()
    {
        return $this->hasOne(Educators::class, ['edu_id' => 'edu_id']);
    }
}
