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
class OccasionV3 extends \yii\db\ActiveRecord
{
    public $uploaded_image;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'occasions_v3';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['moment_id', 'name', 'description', 'the_occasion', 'the_mood', 'the_drink', 'who'], 'required'],
            [['name', 'description', 'the_occasion', 'the_mood', 'the_drink', 'who'], 'string'],
            [['moment_id', 'status', 'updated_by'], 'integer'],
            [['created_at', 'updated_at', 'image', 'uploaded_image'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Occ ID',
            'moment_id' => 'Mom ID',
            'name' => 'Occ Name',
            'description' => 'Occ Description',
            'the_occasion' => 'The Occasion',
            'the_mood' => 'The Mood',
            'the_drink' => 'The Drink',
            'who' => 'Who',
            'image' => 'Occ Image',
            'status' => 'Occ Status',
            'created_at' => 'Occ Created At',
            'updated_at' => 'Occ Updated At',
            'updated_by' => 'Occ Updated By',
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
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'updated_by']);
    }

    public function getMoment()
    {
        return $this->hasOne(MomentV3::class, ['id' => 'moment_id']);
    }

    public static function getAllOccasions()
    {
        return static::find()
            ->with('user', 'moment')
            ->orderBy("name ASC")
            ->all();
    }
}
