<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "educators".
 *
 * @property int $edu_id
 * @property string $edu_name
 * @property string $edu_pass
 * @property string $city
 * @property string $email
 *
 * @property BrandView[] $brandViews
 * @property CatView[] $catViews
 * @property MomentView[] $momentViews
 * @property OccView[] $occViews
 * @property ProTrack[] $proTracks
 * @property TrailSub[] $trailSubs
 * @property TrailSubmissions[] $trailSubmissions
 */
class Educators extends \yii\db\ActiveRecord
{

    public $is_active;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'educators';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['email', 'required', 'on' => ['api']],
            [['edu_name', 'email', 'city'], 'required', 'except' => ['api']],
            [['edu_name'], 'string', 'except' => ['api']],
            [['email'], 'email'],
            ['email', 'validateEmail', 'on' => ['api']],
            [['email', 'auth_key', 'access_token'], 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'Email id already registered', 'except' => ['api']],
            [['status', 'city'], 'integer', 'except' => ['api']],
            [['auth_key', 'access_token', 'is_active'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'edu_id' => 'Educator ID',
            'edu_name' => 'Educator Name',
            'edu_pass' => 'Educator Passcode (Enter a 5 digit Passcode)',
            'city' => 'Market',
            'email' => 'Email',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBrandViews()
    {
        return $this->hasMany(BrandView::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCatViews()
    {
        return $this->hasMany(CatView::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMomentViews()
    {
        return $this->hasMany(MomentView::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccViews()
    {
        return $this->hasMany(OccView::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProTracks()
    {
        return $this->hasMany(ProTrack::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailSubs()
    {
        return $this->hasMany(TrailSub::class, ['edu_id' => 'edu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrailSubmissions()
    {
        return $this->hasMany(TrailSubmissions::class, ['edu_id' => 'edu_id']);
    }

    public function getMarket()
    {
        return $this->hasOne(Market::class, ['id' => 'city']);
    }

    public static function getByPassCode($passcode)
    {
        return static::find()
            ->where(['edu_pass' => $passcode])
            ->all();
    }

    public static function findIdentityByAccessToken($token)
    {
        return static::findOne(['access_token' => $token]);
    }
    public function validateEmail($attribute)
    {
        $find = $this::find()->where(['email' => $this->email, 'status' => 1])->one();
        if (!$find) {
            $this->addError('email', 'Educator not found.');
        }
    }
}
