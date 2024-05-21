<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pro_track".
 *
 * @property int $id
 * @property int $pro_id
 * @property string $event_typ
 * @property int $mom_id
 * @property int $occ_id
 * @property string $user_random_id
 * @property int $edu_id
 * @property string $added_on
 * @property int $track_id track id from app
 * @property int $order_no order no in speed rail
 * @property int $brand_id
 * @property string $category
 * @property string $session_length
 * @property int $cocktail_id
 * @property int $marque_id
 *
 * @property Occasions $occ
 * @property Moments $mom
 * @property Educators $edu
 * @property Products $pro
 */
class ProTrackNew extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pro_track_new';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pro_id', 'mom_id', 'occ_id', 'edu_id', 'track_id', 'order_no', 'brand_id', 'cocktail_id', 'marque_id'], 'integer'],
            [['event_typ', 'user_random_id', 'edu_id', 'track_id'], 'required'],
            [['event_typ', 'user_random_id'], 'string'],
            [['added_on', 'session_length'], 'safe'],
            [['category'], 'string', 'max' => 255],
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
            'pro_id' => 'Pro ID',
            'cocktail_id' => 'Cocktail ID',
            'marque_id' => 'Marque ID',
            'event_typ' => 'Event Typ',
            'mom_id' => 'Mom ID',
            'occ_id' => 'Occ ID',
            'user_random_id' => 'User Random ID',
            'edu_id' => 'Edu ID',
            'added_on' => 'Added On',
            'track_id' => 'Track ID',
            'order_no' => 'Order No',
            'brand_id' => 'Brand ID',
            'category' => 'Category',
            'session_length' => 'Session Length',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOcc()
    {
        return $this->hasOne(Occasions::class, ['occ_id' => 'occ_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMom()
    {
        return $this->hasOne(Moments::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdu()
    {
        return $this->hasOne(Educators::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Products::class, ['pro_id' => 'pro_id']);
    }
}
