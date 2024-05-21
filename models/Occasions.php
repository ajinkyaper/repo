<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "occasions".
 *
 * @property int $occ_id
 * @property string $occ_name
 * @property string $occ_des
 * @property string $occ_img
 * @property int $des_show
 * @property int $mom_id
 *
 * @property BrandView[] $brandViews
 * @property CatView[] $catViews
 * @property OccView[] $occViews
 * @property Moments $mom
 * @property Pmo[] $pmos
 * @property ProTrack[] $proTracks
 */
class Occasions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'occasions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['occ_name', 'occ_des', 'occ_img', 'des_show', 'mom_id'], 'required'],
            [['occ_name', 'occ_des', 'occ_img'], 'string'],
            [['des_show', 'mom_id'], 'integer'],
            [['mom_id'], 'exist', 'skipOnError' => true, 'targetClass' => Moments::class, 'targetAttribute' => ['mom_id' => 'mom_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'occ_id' => 'Occ ID',
            'occ_name' => 'Occ Name',
            'occ_des' => 'Occ Des',
            'occ_img' => 'Occ Img',
            'des_show' => 'Des Show',
            'mom_id' => 'Mom ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandViews()
    {
        return $this->hasMany(BrandView::class, ['occ_id' => 'occ_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatViews()
    {
        return $this->hasMany(CatView::class, ['occ_id' => 'occ_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccViews()
    {
        return $this->hasMany(OccView::class, ['occ_id' => 'occ_id']);
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
    public function getPmos()
    {
        return $this->hasMany(Pmo::class, ['occ_id' => 'occ_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProTracks()
    {
        return $this->hasMany(ProTrack::class, ['occ_id' => 'occ_id']);
    }
}
