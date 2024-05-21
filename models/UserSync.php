<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property int $id
 * @property string $user_id
 */
class UserSync extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user_sync';
    }
    public function beforeSave($insert)
    {

        $this->updated_at = date("Y-m-d H:i:s");
        $this->user_id = Yii::$app->user->identity->id;

        return parent::beforeSave($insert);
    }
}
