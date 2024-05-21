<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marques".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $brand_id
 * @property string $price
 * @property int $status
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property string $image
 *
 * @property MarquesOccasion[] $marquesOccasion
 */
class Marques extends \yii\db\ActiveRecord
{


    public $uploaded_image;
    public $occasion_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marques';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'description', 'price', 'name'], 'required'],
            ['url', 'url'],
            ['image', 'string'],
            //['uploaded_image', 'checkBase64'],
            ['occasion_id', 'each', 'rule' => ['integer']],
            [['uploaded_image', 'status', 'occasion_id'], 'safe']

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Marque Name',
            'description' => 'Description',
            'uploaded_image' => 'Image',
            'price' => 'Price',
            'brand_id' => 'Brand Name',
            'status' => 'Status',
            'url' => 'CTA'
        ];
    }

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
     * Gets query for [[MarquesOccasion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMarquesOccasion()
    {
        return $this->hasMany(MarquesOccasion::class, ['marques_id' => 'id']);
    }

    public function getBrand()
    {
        return $this->hasOne(BrandDetails::class, ['id' => 'brand_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }
    public function checkBase64($attribute)
    {
        echo base64_decode($this->$attribute, true);
        exit;
        if (base64_encode(base64_decode($this->$attribute, true)) === $this->$attribute) {
        } else {
            return $this->addError($attribute, 'Invalid image.');
        }
    }
}
