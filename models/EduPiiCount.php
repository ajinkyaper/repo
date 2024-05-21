<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "edu_pii_count".
 *
 * @property int $id
 * @property int $edu_id
 * @property string $req_time
 * @property int $req_count
 */
class EduPiiCount extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'edu_pii_count';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'req_count'], 'integer'],
            [['req_time'], 'safe'],
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
            'req_count' => 'Req Count',
        ];
    }
}
