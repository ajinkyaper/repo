<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brand_details".
 *
 * @property int $id
 * @property string $brand_name
 * @property int $category_id
 * @property int $status 0-active, 1-inactive
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $updated_by
 *
 * @property Categories $category
 */
class BrandDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brand_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_name', 'category_id'], 'required'],
            [['category_id', 'status',], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['brand_name'], 'string', 'max' => 100],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }
    // public function beforeValidate()
    // {


    //     if ($this->status === 'on') {
    //         $this->status = 1;
    //     } elseif ($this->status === 'off') {
    //         $this->status = 0;
    //     }

    //     if (parent::beforeValidate()) {
    //         return true;
    //     }
    //     return false;
    // }

    public function beforeSave($insert)
    {

        $this->updated_at = date("Y-m-d H:i:s");
        $this->updated_by = Yii::$app->user->identity->id;
        if ($insert) {
            $this->created_at = date("Y-m-d H:i:s");
        }

        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'brand_name' => 'Brand Name',
            'category_id' => 'Category ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
}
