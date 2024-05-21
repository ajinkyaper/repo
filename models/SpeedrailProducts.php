<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "speedrails".
 *
 * @property int $id
 * @property int $speedrail_id
 * @property int $product_id
 * @property string $type
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class SpeedrailProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'speedrail_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['speedrail_id', 'product_id', 'type'], 'required'],
            [['speedrail_id', 'product_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'speedrail_id' => 'SpeedRail ID',
            'product_id' => 'Product Id',
            'type' => 'Product Type',
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
}
