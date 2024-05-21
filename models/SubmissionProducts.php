<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "submission_products".
 *
 * @property int $id
 * @property int $req_id
 * @property int $prod_id
 * @property int $order_no
 * @property string $sub_date
 *
 * @property TrailSubmissions $req
 * @property Products $prod
 */
class SubmissionProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['req_id', 'prod_id', 'order_no'], 'integer'],
            [['sub_date'], 'safe'],
            [['req_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrailSubmissions::class, 'targetAttribute' => ['req_id' => 'id']],
            [['prod_id'], 'exist', 'skipOnError' => true, 'targetClass' => Products::class, 'targetAttribute' => ['prod_id' => 'pro_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'req_id' => 'Req ID',
            'prod_id' => 'Prod ID',
            'order_no' => 'Order No',
            'sub_date' => 'Sub Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReq()
    {
        return $this->hasOne(TrailSubmissions::class, ['id' => 'req_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProd()
    {
        return $this->hasOne(Products::class, ['pro_id' => 'prod_id']);
    }
}
