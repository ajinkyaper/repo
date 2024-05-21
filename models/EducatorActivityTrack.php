<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pin_qr_track".
 *
 * @property int $id
 * @property int $edu_id
 * @property int $activity
 * @property int $pin_returned
 * @property int $pin_downloaded
 * @property string $device_id
 * @property string|null $timestamp
 * @property string|null $created_at
 */
class EducatorActivityTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'educator_activity_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'activity'], 'required'],
            [['pin_downloaded', 'pin_returned', 'device_id', 'edu_name'], 'safe'],
        ];
    }


    public function beforeSave($insert)
    {

        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }
    public function getEducators() // this will return related occasions
    {
        return $this->hasMany(Educators::class, ['edu_id' => 'edu_id']);
    }
}
