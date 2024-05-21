<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "products".
 *
 * @property int $pro_id
 * @property string $pro_name
 * @property string $pro_des
 * @property string $pro_img
 * @property string $pro_type
 * @property string $category
 * @property int $varient_id
 * @property int $price_band
 * @property int $brand_id
 * @property string $brand_name
 * @property string $sub_name
 * @property string $des_url
 * @property string $cta
 *
 * @property ProTrack[] $proTracks
 * @property Brands $brand
 */
class Products extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pro_name', 'pro_des', 'pro_img', 'pro_type', 'category', 'varient_id', 'brand_id', 'brand_name', 'des_url', 'cta'], 'required'],
            [['pro_name', 'pro_des', 'pro_img', 'pro_type', 'category', 'brand_name', 'sub_name', 'des_url', 'cta'], 'string'],
            [['varient_id', 'price_band', 'brand_id'], 'integer'],
            [['brand_id'], 'exist', 'skipOnError' => true, 'targetClass' => Brands::class, 'targetAttribute' => ['brand_id' => 'brand_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'pro_id' => 'Pro ID',
            'pro_name' => 'Pro Name',
            'pro_des' => 'Pro Des',
            'pro_img' => 'Pro Img',
            'pro_type' => 'Pro Type',
            'category' => 'Category',
            'varient_id' => 'Varient ID',
            'price_band' => 'Price Band',
            'brand_id' => 'Brand ID',
            'brand_name' => 'Brand Name',
            'sub_name' => 'Sub Name',
            'des_url' => 'Des Url',
            'cta' => 'Cta',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProTracks()
    {
        return $this->hasMany(ProTrack::class, ['pro_id' => 'pro_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrand()
    {
        return $this->hasOne(Brands::class, ['brand_id' => 'brand_id']);
    }
}
