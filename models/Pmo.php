<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pmo".
 *
 * @property int $pmo_id
 * @property int $occ_id
 * @property int $pro_id
 *
 * @property Products $pro
 * @property Occasions $occ
 */
class Pmo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pmo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pmo_id', 'occ_id', 'pro_id'], 'required'],
            [['pmo_id', 'occ_id', 'pro_id'], 'integer'],
            [['pmo_id'], 'unique'],
            [['pro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['pro_id' => 'pro_id']],
            [['occ_id'], 'exist', 'skipOnError' => true, 'targetClass' => Occasions::class, 'targetAttribute' => ['occ_id' => 'occ_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pmo_id' => 'Pmo ID',
            'occ_id' => 'Occ ID',
            'pro_id' => 'Pro ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPro()
    {
        return $this->hasOne(Products::class, ['pro_id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOcc()
    {
        return $this->hasOne(Occasions::class, ['occ_id' => 'occ_id']);
    }
}
