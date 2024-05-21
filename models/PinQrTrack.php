<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pin_qr_track".
 *
 * @property int $id
 * @property int $pin
 * @property int $pin_mode
 * @property int $qr_mode
 * @property int $consumer_page_visit
 * @property int $loading_page_visit
 * @property string|null $created_at
 */
class PinQrTrack extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pin_qr_track';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pin'], 'required'],
        ];
    }


    public function beforeSave($insert)
    {

        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }
}
