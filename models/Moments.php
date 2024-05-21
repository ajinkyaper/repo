<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "moments".
 *
 * @property int $mom_id
 * @property string $mom_name
 * @property string $mom_des
 * @property string $mom_img
 * @property int $des_show
 *
 * @property BrandView[] $brandViews
 * @property CatView[] $catViews
 * @property MomentView[] $momentViews
 * @property OccView[] $occViews
 * @property Occasions[] $occasions
 * @property ProTrack[] $proTracks
 */
class Moments extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'moments';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['mom_name', 'mom_des', 'mom_img', 'des_show'], 'required'],
            [['mom_name', 'mom_des', 'mom_img'], 'string'],
            [['des_show'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'mom_id' => 'Mom ID',
            'mom_name' => 'Mom Name',
            'mom_des' => 'Mom Des',
            'mom_img' => 'Mom Img',
            'des_show' => 'Des Show',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandViews()
    {
        return $this->hasMany(BrandView::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatViews()
    {
        return $this->hasMany(CatView::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMomentViews()
    {
        return $this->hasMany(MomentView::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccViews()
    {
        return $this->hasMany(OccView::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccasions()
    {
        return $this->hasMany(Occasions::class, ['mom_id' => 'mom_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProTracks()
    {
        return $this->hasMany(ProTrack::class, ['mom_id' => 'mom_id']);
    }
}
