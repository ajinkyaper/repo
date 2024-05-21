<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "speedrails".
 *
 * @property int $id
 * @property int $edu_id
 * @property int $pin
 * @property int $view_count
 * @property int $trail_submission_id
 * @property int $pin_entered
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SpeedRails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speedrails';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edu_id', 'pin'], 'required'],
            [['edu_id', 'trail_submission_id'], 'integer'],
            [['created_at', 'updated_at', 'view_count', 'pin_entered', 'trail_submission_id'], 'safe'],
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
            'pin' => 'Pin',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {

        $this->updated_at = date("Y-m-d H:i:s");
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducators()
    {
        return $this->hasMany(Educators::class, ['id' => 'edu_id']);
    }
}
