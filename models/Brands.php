<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "brands".
 *
 * @property int $brand_id
 * @property string $brand_name
 * @property string $brand_des
 * @property string $brand_img
 * @property int $des_show
 *
 * @property BrandView[] $brandViews
 * @property Products[] $products
 */
class Brands extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'brands';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_name', 'brand_des', 'brand_img', 'des_show'], 'required'],
            [['brand_name', 'brand_des', 'brand_img'], 'string'],
            [['des_show'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'brand_id' => 'Brand ID',
            'brand_name' => 'Brand Name',
            'brand_des' => 'Brand Des',
            'brand_img' => 'Brand Img',
            'des_show' => 'Des Show',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandViews()
    {
        return $this->hasMany(BrandView::class, ['brand_id' => 'brand_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Products::class, ['brand_id' => 'brand_id']);
    }
}
