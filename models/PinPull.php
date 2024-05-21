<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "speedrails".
 *
 * @property int $id
 * @property int $pin_number
 * @property int $allocated_to
 * @property int $is_used
 * @property string|null $created_at
 */
class PinPull extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pin_pull';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pin_number'], 'required'],
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
