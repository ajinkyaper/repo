<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "submission_products_v3".
 *
 * @property int $id
 * @property int $req_id
 * @property int $cocktail_id
 * @property int $marque_id
 * @property int $order_no
 * @property string $sub_date
 *
 * @property TrailSubmissions $req
 * @property Products $prod
 */
class SubmissionProductV3 extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'submission_products_v3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['req_id', 'cocktail_id', 'marque_id', 'order_no'], 'integer'],
            [['sub_date'], 'safe'],
            [['req_id'], 'exist', 'skipOnError' => true, 'targetClass' => TrailSubmissions::className(), 'targetAttribute' => ['req_id' => 'id']],
            [['cocktail_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cocktail::className(), 'targetAttribute' => ['cocktail_id' => 'id']],
            [['marque_id'], 'exist', 'skipOnError' => true, 'targetClass' => Marques::className(), 'targetAttribute' => ['marque_id' => 'id']],
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
            'cocktail_id' => 'Cocktail ID',
            'marque_id' => 'Marques ID',
            'order_no' => 'Order No',
            'sub_date' => 'Sub Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReq()
    {
        return $this->hasOne(TrailSubmissions::className(), ['id' => 'req_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCocktail()
    {
        return $this->hasOne(Cocktail::className(), ['id' => 'cocktail_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarque()
    {
        return $this->hasOne(Marques::className(), ['id' => 'marque_id']);
    }
}
